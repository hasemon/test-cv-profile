<template>
    <b-container class="mt-5">
        <b-row class="justify-content-center">
            <b-col cols="12" md="6">
                <b-card header="My Profile" header-bg-variant="primary" header-text-variant="white" class="shadow-sm text-center">
                    <b-button
                        variant="primary"
                        @click="$router.push({ name: 'profile.page', query: { is_manage: true } });"
                    >
                        Manage Profile
                    </b-button>

                    <br>

                    <b-button
                        v-if="hasProfile"
                        variant="primary"
                        @click="$router.push({ name: 'profile.page', query: { is_manage: false } });"
                        class="mt-2"
                    >
                        View Profile
                    </b-button>


                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>

import axios from "axios";
import { HTTP } from "@/http.js";

export default {
    data() {
        return {
            hasProfile: false,
        }
    },
    methods: {
        fetchProfile() {
            axios.get(`${HTTP.baseURL}/api/profile`)
                .then(response => {
                    const {data} = response.data;
                    if (!data) return;

                    this.hasProfile = !!data.name;

                })
                .catch(err => {
                    console.error(err);
                    alert("Failed to fetch profile");
                });
        },
    },
    created() {
        this.fetchProfile();
    },
}
</script>
