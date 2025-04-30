<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3';
import { useAppearance } from '@/composables/useAppearance';
import { Button } from '@/components/ui/button';
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const { appearance, changeAppearance } = useAppearance();

const user = computed(() => page.props.auth.user)

</script>

<template>
    <Head title="Anjay">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <p class="dark:text-red-500">dasdsa</p>
    <h1 class="text-3xl font-bold ">Anjay</h1>
    <h1 class="text-3xl font-bold ">halo, {{ user.name }}</h1>
    <p>{{ appearance }}</p>

    <div class="flex justify-betweeen">
        <Button @click="changeAppearance('dark')">Dark</Button>
        <Button @click="changeAppearance('light')">Light</Button>
    </div>


</template>
