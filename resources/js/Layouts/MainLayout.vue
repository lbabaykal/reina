<script>
import Header from "../Components/Header.vue";

export default {
    name: "MainLayout",
    components: {Header}
}
</script>

<template>
    <Header/>

    <div class="mt-14">
        <RouterView/>
    </div>
</template>
