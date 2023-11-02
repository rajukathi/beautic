<template>
	<slot name="addcategorylot">
		<button class="btn btn-primary" @click="OpenForm">Add Category</button>
	</slot>
</template>
<script>
import { onMounted, ref, defineEmits } from "vue";
import { useSweetform } from "@chronicstone/vue-sweetforms";
import { helpers, sameAs } from "@vuelidate/validators";

export default {
	name: "CategoryAdd",
	emits: ["isCategoryAdded"],
  	setup(props,{emit}) {

    	const { createForm } = useSweetform();
    	let parentCategories = {};

 	    const OpenForm = async () => {
	      	const { isCompleted, formData } = await createForm({
	        	title: "Add Category",
	        	fields: [
		          	{
		            	key: "name",
		            	label: "Name",
		            	type: "text",
		            	placeholder: "Enter category name here",
		            	required: true,
		          	},
		          	{
		            	key: "parent_id",
		            	label: "Parent Category",
		            	type: "select",
		            	placeholder: "Select parent category name here",
		            	required: false,
		            	options: parentCategories.length > 0 ? Object.entries(parentCategories).map((y) => ({label: y[1].name, value: y[1].id})) : []	
		          	}		            
	        	],
	      	}).catch((err) => console.error(err));
	    	
	      	if ( isCompleted ) {
	      		saveData( formData );
	      	}
	    };

	    function saveData( formData ) {
		  	fetch('http://localhost:8000/api/category/save',{
		    	method:  'POST',
		    	headers: {
		      		'Content-Type': 'application/json'
		    	},
		    	body: JSON.stringify(formData)
		  	})
		    .then(response => response.json())
		    .then((data) => {
		    	emit("isCategoryAdded", "yesCategoryAdded");
		    });
		}

		const doSearch = (skip, take, order, sort) => {

			let queryParams = '?skip=' + skip + '&take=' + take + '&order=' + order + '&sort=' + sort + '&getParentCategory=true';

		  	// Start use axios to get data from Server
		  	fetch('http://localhost:8000/api/category' + queryParams)
		  	.then((response) => {
		  		if( response.status != 200 ){
		            throw response.status;
		        }else{
		            return response.json();
		        }
			}).then((response) => {
			    parentCategories = response;
			    console.log(parentCategories)
		  	}).catch(error => {
			    console.error('Panic at the disco:', error);
			});
		};

		onMounted(() => {

			doSearch(0, 10, "id", "desc");
		});

	    return { 
	    	OpenForm,
	    };
	},
};
</script>
