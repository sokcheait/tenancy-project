<template>
    <div class="w-[16%] relative">
        <div class="absolute z-10 w-full">
            <div class="h-full fixed bg-white w-[16%]">
                <div class="shadow-xl h-full">
                    <ul class="list-none px-2">
                        <li v-for="nav_menus in menu" :key="nav_menus" class="float-left w-full my-2 text-gray-500">
                            <NavLink :href="route(nav_menus.link)" :active="route().current(nav_menus.link)">
                                <span class="float-left mr-1"><component :is="heroIcons[nav_menus.icon]" class='h-8 w-8' /></span>
                                <span class="float-left my-1">
                                    {{ nav_menus.lable  }}
                                </span>
                            </NavLink>    
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Nav from '@/Layouts/Nav/index.js';
import * as heroIcons from '@heroicons/vue/24/solid';
import { Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
export default {
    name: "Navigation",
    components: {
        Nav,
        heroIcons,
        Link,
        NavLink
    },
    setup() {
        const menu = Nav
        return { menu }
    },
    data() {
        return {
            heroIcons: heroIcons
        }
    }
}
</script>
