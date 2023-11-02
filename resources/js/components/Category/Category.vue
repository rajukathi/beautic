<template>
	<div class="row content-header">
		<div class="col-md-9">
			<h1>Category Listing</h1>
		</div>
		<div class="col-md-3">
			<FormProvider>
			    <CategoryAdd @isCategoryAdded="yesCategoryAdded">
			    	<template v-slot:addcategorylot></template>
			    </CategoryAdd>
			</FormProvider>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-md-12">
		  	<table-lite
		    	:has-checkbox="true"
		    	:is-slot-mode="true"
		    	:is-loading="table.isLoading"
		    	:columns="table.columns"
		    	:rows="table.rows"
		    	:total="table.totalRecordCount"
		    	:sortable="table.sortable"
		    	@do-search="doSearch"
		  	>
		  		<template v-slot:icon="data">
			        <div>
			        	<a href="#" class="btn btn-warning" @click="handleEditCategory(data.value)">Edit</a> ||
			        	<a href="#"  class="btn btn-danger" @click="handleDeleteCategory(data.value)">Delete</a>
			        </div>
			    </template>
  			</table-lite>
		</div>
	</div>
</template>
<script>

import { ref, reactive, onMounted, watch } from "vue";
import TableLite from "vue3-table-lite";
import CategoryAdd from "./CategoryAdd.vue";

export default {
	name: 'category',
	components: { TableLite,CategoryAdd },
	setup() {

		const table = reactive({
		  	isLoading: false,
		  	columns: [
		    	{
		      		label: "ID",
		      		field: "id",
		      		width: "3%",
		      		sortable: true,
		      		isKey: true,
		    	},
		    	{
		      		label: "Name",
		      		field: "name",
		      		width: "35%",
		      		sortable: true,
		    	},
		    	{
		      		label: "Parent Category",
		      		field: "parent_category",
		      		width: "35%",
		      		sortable: true,
		    	},
		    	{
		          	label: " ",
		          	field: "icon",
		          	sortable: false,
		        },
			 ],
		  	rows: [],
		  	totalRecordCount: 0,
		  	sortable: {
		    	order: "id",
		    	sort: "asc",
		  	},
		});

		const doSearch = (skip, take, order, sort) => {

		  	table.isLoading = true;
			let queryParams = '?skip=' + skip + '&take=' + take + '&order=' + order + '&sort=' + sort;

		  	// Start use axios to get data from Server
		  	fetch('http://localhost:8000/api/category' + queryParams)
		  	.then((response) => {
		  		if( response.status != 200 ){
		            throw response.status;
		        }else{
		            return response.json();
		        }
			}).then((response) => {
			    table.rows = response;
			    table.totalRecordCount = response.length;
			    table.sortable.order = order;
			    table.sortable.sort = sort;
				table.isLoading = false;
		  	}).catch(error => {
		  		table.isLoading = false;
			    console.error('Panic at the disco:', error);
			});
		};

		const yesCategoryAdded = () => {

			doSearch(0, 0, "id", "desc");			
		}

		const handleEditCategory = (requestData) => {

			/*addCategory.value = true;
			console.log(requestData.value.name);*/
		}
		
		const handleDeleteCategory = (requestData) => {
			
			console.log(requestData);
			fetch('http://localhost:8000/api/category/delete/' + requestData.id)
		  	.then((response) => {
		  		if( response.status != 200 ){
		            throw response.status;
		        }else{
		            return response.json();
		        }
			}).then((response) => {
				doSearch(0, 0, "id", "desc");    
				table.isLoading = false;
		  	}).catch(error => {
		  		table.isLoading = false;
			    console.error('Panic at the disco:', error);
			});
		}

		onMounted(() => {

			doSearch(0, 10, "id", "desc");
		});

		return {
			table,
      		doSearch,
      		yesCategoryAdded,
      		handleEditCategory,
      		handleDeleteCategory,
		}
	}
}
</script>