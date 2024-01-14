<template>
    <div>
       <router-link to="/login">Login</router-link>
		 HOME PAGE
    </div>
</template>
<script>
export default {
    created() {
        window.location.replace("/login");
    },
}
</script>
<style lang="">
    
</style>