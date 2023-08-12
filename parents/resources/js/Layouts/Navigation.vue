<template>
    <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center h-8">
                <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
                </div>
            </li>
            <li v-for="nav_menus in menu" :key="nav_menus">
                <div v-if="nav_menus.header" class="p-2 mx-1 my-2 text-sm font-bold text-gray-400 uppercase border-y border-y-sky-600">
                    {{ nav_menus.header.title }}
                </div>
                <NavLink v-if="can(nav_menus.redirect) || is_superAdmin('super-admin') || nav_menus.redirect=='dashboard' " :href="route(nav_menus.link)" :active="route().current(nav_menus.link)" class="">
                    <span class="inline-flex justify-center items-center ml-4"><component :is="heroIcons[nav_menus.icon]" class='h-6 w-6' /></span>
                    <span class="ml-2 text-sm tracking-wide truncate">
                        {{ nav_menus.lable  }}
                    </span>
                </NavLink>
            </li>
        </ul>
            <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">Copyright Sokchea @2023</p>
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
        const menu = Nav;
        return { menu }
    },
    data() {
        return {
            heroIcons: heroIcons,
        }
    }
}
</script>
