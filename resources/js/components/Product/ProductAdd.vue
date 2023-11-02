<template>
	<slot name="addproductlot">
		<button class="btn btn-primary" @click="OpenForm">Add Product</button>
	</slot>
</template>
<script>
import { onMounted, ref, defineEmits } from "vue";
import { useSweetform } from "@chronicstone/vue-sweetforms";
import { helpers, sameAs } from "@vuelidate/validators";

export default {
	name: "ProductAdd",
	emits: ["isProductAdded"],
  	setup(props,{emit}) {

    	const { createForm } = useSweetform();
    	let parentCategories = {};
    	let tags = {};

 	    const OpenForm = async () => {
	      	const { isCompleted, formData } = await createForm({
	        	title: "Add Product",
	        	fields: [
		          	{
		            	key: "name",
		            	label: "Name",
		            	type: "text",
		            	placeholder: "Enter product name here",
		            	required: true,
		          	},
		          	{
		            	key: "qty",
		            	label: "Quantity",
		            	type: "text",
		            	placeholder: "Enter product quantity here",
		            	required: true,
		          	},
		          	{
		            	key: "amount",
		            	label: "Amount",
		            	type: "text",
		            	placeholder: "Enter product amount here",
		            	required: true,
		          	},
		          	{
		            	key: "category_id",
		            	label: "Categories",
		            	type: "select",
		            	placeholder: "Select parent product name here",
		            	required: true,
		            	options: parentCategories.length > 0 ? Object.entries(parentCategories).map((y) => ({label: y[1].name, value: y[1].id})) : []	
		          	},
		          	{
		            	key: "tag_id",
		            	label: "Tags",
		            	type: "select",
		            	placeholder: "Select parent tag name here",
		            	required: false,
		            	options: tags.length > 0 ? Object.entries(tags).map((y) => ({label: y[1].name, value: y[1].id})) : []	
		          	}	            
	        	],
	      	}).catch((err) => console.error(err));
	    	
	      	if ( isCompleted ) {
	      		saveData( formData );
	      	}
	    };

	    function saveData( formData ) {
		  	fetch('http://localhost:8000/api/product/save',{
		    	method:  'POST',
		    	headers: {
		      		'Content-Type': 'application/json'
		    	},
		    	body: JSON.stringify(formData)
		  	})
		    .then(response => response.json())
		    .then((data) => {
		    	emit("isProductAdded", "yesProductAdded");
		    });
		}

		const getCategory = (skip, take, order, sort) => {

			let queryParams = '?skip=' + skip + '&take=' + take + '&order=' + order + '&sort=' + sort + '&getParentProduct=true';

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

		const getTags = (skip, take, order, sort) => {

			let queryParams = '?skip=' + skip + '&take=' + take + '&order=' + order + '&sort=' + sort + '&getParentProduct=true';

		  	// Start use axios to get data from Server
		  	fetch('http://localhost:8000/api/tags' + queryParams)
		  	.then((response) => {
		  		if( response.status != 200 ){
		            throw response.status;
		        }else{
		            return response.json();
		        }
			}).then((response) => {
			    tags = response;
			    console.log(tags)
		  	}).catch(error => {
			    console.error('Panic at the disco:', error);
			});
		};

		onMounted(() => {

			getCategory(0, 0, "id", "desc");
			getTags(0, 0, "id", "desc");
		});

	    return { 
	    	OpenForm,
	    };
	},
};
</script>
