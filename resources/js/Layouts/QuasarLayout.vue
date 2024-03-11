<template>
    <q-layout view="hHh lpR fFf">
        <q-header elevated class="text-white bg-indigo-6" height-hint="98">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

                <q-toolbar-title class="flex items-center">
                    <q-avatar>
                        <img
                            src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg"
                        />
                    </q-avatar>
                    <q-tabs>
                        <q-route-tab :href="route('dashboard')" label="School ERP" class="py-2" />
                    </q-tabs>
                </q-toolbar-title>
                
                <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                </div>
                <q-btn-dropdown
                    color="primary"
                    class="ml-4"
                    :label="$page.props.auth.user.name"
                >
                    <q-list>
                        <q-item clickable v-close-popup @click="profile">
                            <q-item-section>
                                <q-item-label>Profile</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item clickable v-close-popup @click="logout">
                            <q-item-section>
                                <q-item-label>Logout</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-btn-dropdown>
            </q-toolbar>

            <q-tabs align="left">
                <q-route-tab
                    label="Notesheet"
                />
                <q-route-tab
                    :href="route('dashboard')"
                    label="Dashboard"
                />
                <q-route-tab
                     
                     :href="route('roles')"
                     label="Roles"
                 />
                 <!-- v-if="$page.props.user.roles.includes('admin')" -->
                 <q-route-tab
                     
                     :href="route('usersRole')"
                     label="Users"
                 />
            </q-tabs>
        </q-header>

        <q-drawer v-model="leftDrawerOpen" side="left" bordered>
            <q-list bordered padding class="rounded-borders text-primary">
                <Link href="/">
                    <q-item
                        clickable
                        v-ripple
                        active-class="my-menu-link"
                    >
                        <q-item-section avatar>
                            <q-icon name="home" />
                        </q-item-section>

                        <q-item-section>Home</q-item-section>
                    </q-item>
                </Link>
                <q-separator spaced />
                <Link :href="route('class.index')">
                <q-item
                    clickable
                    v-ripple
                    active-class="my-menu-link"
                >
                    <q-item-section avatar>
                        <q-icon name="school" />
                    </q-item-section>

                    <q-item-section>Class</q-item-section>
                </q-item>
                </Link>
                
                <Link :href="route('subject.index')">
                    <q-item
                        clickable
                        v-ripple
                        active-class="my-menu-link"
                    >
                        <q-item-section avatar>
                            <q-icon name="assignment_ind" />
                        </q-item-section>

                        <q-item-section>Subjects</q-item-section>
                    </q-item>
                </Link>
                <q-separator spaced />
                <Link :href="route('student.index')">
                    <q-item
                        clickable
                        v-ripple
                        active-class="my-menu-link"
                    >
                        <q-item-section avatar>
                            <q-icon name="child_care" />
                        </q-item-section>

                        <q-item-section>Student</q-item-section>
                    </q-item>
                </Link>
                <Link :href="route('teacher.index')">
                    <q-item
                        clickable
                        v-ripple
                        active-class="my-menu-link"
                    >
                        <q-item-section avatar>
                            <q-icon name="assignment_ind" />
                        </q-item-section>

                        <q-item-section>Teacher</q-item-section>
                    </q-item>
                </Link>
            </q-list>
        </q-drawer>

        <q-page-container>
            <slot></slot>
        </q-page-container>

        <q-footer elevated class="text-white bg-grey-8">
            <q-toolbar align="middle">
                <q-toolbar-title>
                    <q-avatar>
                        <img
                            src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg"
                        />
                    </q-avatar>
                    <div align="middle">School ERP</div>
                </q-toolbar-title>
            </q-toolbar>
        </q-footer>
    </q-layout>
</template>

<script setup>
import { computed, ref } from "vue";
import { router, usePage, Link } from "@inertiajs/vue3";

const page = usePage();

const link = ref("");

const leftDrawerOpen = ref(false);
const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value;
};

// Redirect to a route using Inertia
const profile = () => {
    // Use Inertia to visit the profile route
    router.get(route("profile.show"));
    // router.visit("/user/profile-information", { method: "get" });
};
const logout = () => {
    // Use Inertia to visit the logout route
    router.post(route("logout"));
};


</script>
