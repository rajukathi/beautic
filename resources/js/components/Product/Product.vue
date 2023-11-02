<template>
	<div class="row content-header">
		<div class="col-md-9">
			<h1>Product Listing</h1>
		</div>
		<div class="col-md-3">
			<FormProvider>
			    <ProductAdd @isProductAdded="yesProductAdded">
			    	<template v-slot:addproductlot></template>
			    </ProductAdd>
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
			        	<a href="#" class="btn btn-warning" @click="handleEditProduct(data.value)">Edit</a> ||
			        	<a href="#"  class="btn btn-danger" @click="handleDeleteProduct(data.value)">Delete</a>
			        </div>
			    </template>
  			</table-lite>
		</div>
	</div>
</template>
<script>

import { ref, reactive, onMounted, watch } from "vue";
import TableLite from "vue3-table-lite";
import ProductAdd from "./ProductAdd.vue";

export default {
	name: 'product',
	components: { TableLite,ProductAdd },
	setup() {

		const table = reactive({
		  	isLoading: false,
		  	columns: [
		    	{
		      		label: "ID",
		      		field: "id",
		      		width: "5%",
		      		sortable: true,
		      		isKey: true,
		    	},
		    	{
		      		label: "Name",
		      		field: "name",
		      		width: "10%",
		      		sortable: true,
		    	},
		    	{
		      		label: "Quantity",
		      		field: "qty",
		      		width: "5%",
		      		sortable: true,
		    	},
		    	{
		      		label: "Amount",
		      		field: "amount",
		      		width: "10%",
		      		sortable: true,
		    	},
		    	{
		      		label: "Categories",
		      		field: "categories",
		      		width: "30%",
		      		sortable: true,
		    	},
		    	{
		      		label: "Parent Tags",
		      		field: "tags",
		      		width: "30%",
		      		sortable: true,
		    	},
		    	{
		          	label: " ",
		          	field: "icon",
		          	width: "10%",
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
		  	fetch('http://localhost:8000/api/product' + queryParams)
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

		const yesProductAdded = () => {

			doSearch(0, 0, "id", "desc");			
		}

		const handleEditProduct = (requestData) => {

			/*addProduct.value = true;
			console.log(requestData.value.name);*/
		}
		
		const handleDeleteProduct = (requestData) => {
			
			console.log(requestData);
			fetch('http://localhost:8000/api/product/delete/' + requestData.id)
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
      		yesProductAdded,
      		handleEditProduct,
      		handleDeleteProduct,
		}
	}
}
</script>