<template>
  <!-- <Tags></Tags> -->
  <Category></Category>
</template>
<script>
import { ref, reactive, onMounted } from "vue";

//import Tags from "./Tags/Tags.vue";
import Category from "./Category/Category.vue";
export default {
  name: 'example-component',
  components: { 
    //Tags 
    Category
  },
};
</script>