<template>
    <b-container class="mt-5">
        <b-row class="justify-content-center">
            <b-col cols="12" md="6">
                <b-card header="My Profile" header-bg-variant="primary" header-text-variant="white" class="shadow-sm text-center">

                    <b-img
                        :src="`${HTTP.baseURL}/storage/${profileData.image}`"
                        rounded="circle"
                        class="border mb-3"
                        fluid
                        style="width: 120px; height: 120px; object-fit: cover;"
                    ></b-img>

                    <h4>{{ profileData.name }}</h4>

                    <p><strong>Gender:</strong> {{ profileData.gender }}</p>

                    <p>
                        <strong>Hobbies:</strong>
                        <span v-if="profileData.hobbies && profileData.hobbies.length">
                          {{ profileData.hobbies.join(', ') }}
                        </span>
                        <span v-else>N/A</span>
                    </p>
                    <b-table :fields="fields" :items="profileData.education">
                        <template #cell(start_date)="data">
                            {{ formatDateForDisplay(data.item.start_date) }}
                        </template>

                        <template #cell(end_date)="data">
                            {{ formatDateForDisplay(data.item.end_date) }}
                        </template>
                    </b-table>

                    <template v-if="isManage === true">
                        <b-button variant="primary" @click="$router.push({ name: 'profile.edit', params: { id: profileData.id } })" v-if="hasProfile"> Edit Profile</b-button>
                        <b-button variant="primary" @click="$router.push({ name: 'profile.create' })" v-else>Create Profile</b-button>
                    </template>
                    <b-button
                        variant="primary"
                        @click="$router.push({ name: 'profile.dashboard' });"
                        style="margin-left:2px;"
                    >
                        Dashboard
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
    computed: {
        HTTP() {
            return HTTP
        }
    },
    data() {
        return {
            isManage: this.$route.query.is_manage,
            fields: [
                { key: 'degree', label: 'Degree' },
                { key: 'institute', label: 'Institute' },
                { key: 'start_date', label: 'Start Date' },
                { key: 'end_date', label: 'End Date' }
            ],
            hasProfile: false,
            profileData: {
                id: null,
                name: null,
                gender: null,
                hobbies: [],
                education: [],
                image: null
            }
        }
    },
    methods: {
        formatDateForDisplay(date) {
            if (!date) return '';
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}-${month}-${year}`; // D-m-Y
        },
        fetchProfile() {
            axios.get(`${HTTP.baseURL}/api/profile`)
                .then(response => {
                    const {data} = response.data;
                    if (!data) return;

                    this.hasProfile = !!data.name;

                    this.profileData.id = data.id ?? null;
                    this.profileData.name = data.name ?? null;
                    this.profileData.gender = data.gender ?? null;
                    this.profileData.hobbies = Array.isArray(data.hobbies) ? data.hobbies : JSON.parse(data.hobbies || '[]');
                    this.profileData.education = Array.isArray(data.education) ? data.education : JSON.parse(data.education || '[]');
                    this.profileData.image = data.image ?? null;

                    console.log("profileData after fetch:", this.profileData);
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
