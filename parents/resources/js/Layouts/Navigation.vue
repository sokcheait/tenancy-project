<template>
    <!-- <div class="w-[16%] relative">
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
    </div> -->
    <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
            <li class="px-5 hidden md:block">
                <div class="flex flex-row items-center h-8">
                <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
                </div>
            </li>

            <li v-for="nav_menus in menu" :key="nav_menus">
                <NavLink :href="route(nav_menus.link)" :active="route().current(nav_menus.link)" class="">

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
