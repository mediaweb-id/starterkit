<script setup lang="ts">

import { ChevronsUpDown } from 'lucide-vue-next';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem,useSidebar } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
    items: NavItem[];
}>();

const page = usePage<SharedData>();
const { isMobile, state } = useSidebar();
</script>

<template>
    <SidebarGroup class="px-0 py-0 border-t">
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <DropdownMenu v-if="item.menus.length > 0" >
                    <DropdownMenuTrigger as-child v-if="item.type == 'header'">
                        <SidebarMenuButton size="lg" class="pl-4 data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground border-b" 
                        :class="{'px-0 justify-center mx-auto' : state === 'collapsed'}">
                            <i class="fa " :class="item.icon"></i>
                            <span :class="{'hidden' : state === 'collapsed'}">{{ item.title }}</span>
                            <ChevronsUpDown class="ml-auto size-4"  :class="{'hidden' : state === 'collapsed'}"/>
                        </SidebarMenuButton>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent 
                        class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                        :side="isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'"
                        align="end" 
                        :side-offset="4"
                    >
                        <SidebarMenuButton  
                        v-for="(menu,i) in item.menus" :key="i"
                        as-child :is-active="menu.href === page.props.current_path"
                        :tooltip="menu.title"
                        class="!py-3 !px-4 h-auto"
                    >
                        <Link :href="menu.href">
                            <i class="fa " :class="menu.icon"></i>
                            <span :class="{'hidden' : state === 'collapsed'}">{{ menu.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                    </DropdownMenuContent>
                </DropdownMenu>
                <div v-else>
                    <h3 v-if="item.type == 'header'" class="flex items-center gap-2 font-semibold text-sm px-4 py-3 border-b bg-white rounded-md"
                    :class="{'px-0 justify-center mx-auto' : state === 'collapsed'}">
                        <i class="fa " :class="item.icon"></i>
                        <span :class="{'hidden' : state === 'collapsed'}">{{ item.title }}</span>
                    </h3>

                    <SidebarMenuButton  v-else
                        as-child :is-active="item.href === page.props.current_path"
                        :tooltip="item.title"
                        class="h-auto border-b px-4"
                        :class="{'flex gap-0 justify-center mx-auto !group-data-[collapsible=icon]:pr-0 !px-2' : state === 'collapsed'}"
                    >
                        <Link :href="item.href">
                            <i class="fa " :class="item.icon"></i>
                            <span :class="{'hidden' : state === 'collapsed'}">{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </div>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
