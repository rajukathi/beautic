<template>
	<slot name="addtagslot">
		<button class="btn btn-primary" @click="OpenForm">Add Tags</button>
	</slot>
</template>
<script>
import { onMounted, ref, defineEmits } from "vue";
import { useSweetform } from "@chronicstone/vue-sweetforms";
import { helpers, sameAs } from "@vuelidate/validators";

export default {
	name: "TagAdd",
  	setup(props,{emit}) {

    	const { createForm } = useSweetform();

 	    const OpenForm = async () => {
	      	const { isCompleted, formData } = await createForm({
	        	title: "Add Tag",
	        	fields: [
		          	{
		            	key: "name",
		            	label: "Name",
		            	type: "text",
		            	placeholder: "Enter Tag name here",
		            	required: true,
		          	},
	        	],
	      	}).catch((err) => console.error(err));
	    	
	      	if ( isCompleted ) {
	      		saveData( formData );
	      	}
	    };

	    function saveData( formData ) {
		  	fetch('http://localhost:8000/api/tags/save',{
		    	method:  'POST',
		    	headers: {
		      		'Content-Type': 'application/json'
		    	},
		    	body: JSON.stringify(formData)
		  	})
		    .then(response => response.json())
		    .then((data) => {
		    	emit("isTagAdded", "yesTagAdded");
		    });
		}

	    return { 
	    	OpenForm,
	    };
	},
};
</script>
