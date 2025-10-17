<template>
    <b-container class="mt-5">
        <b-row class="justify-content-center">
            <b-col cols="12" md="6">
                <b-card header="Create Profile" header-bg-variant="primary" header-text-variant="white" class="shadow-sm">

                    <div class="text-center mb-4">
                        <b-img
                            :src="avatarPreview || profile.image"
                            rounded="circle"
                            class="border"
                            fluid
                            style="width: 120px; height: 120px; object-fit: cover;"
                        ></b-img>
                    </div>


                        <b-form-group label="Name" label-for="name">
                            <b-form-input
                                id="name"
                                v-model="profile.name"
                                required
                            ></b-form-input>
                        </b-form-group>

                        <b-form-group label="Gender" label-for="gender">
                            <b-form-select
                                id="gender"
                                v-model="profile.gender"
                                :options="genderOptions"
                                required
                            ></b-form-select>
                        </b-form-group>

                        <b-form-group label="Hobbies">
                            <b-form-checkbox-group
                            v-model="profile.hobbies"
                            :options="hobbiesOptions"
                        ></b-form-checkbox-group>
                        </b-form-group>

                        <b-form-group label="Profile Image">
                            <b-form-file
                                accept="image/*"
                                @change="onFileChange"
                            ></b-form-file>
                        </b-form-group>


                        <b-form-group label="Education" class="mt-2">
                            <div v-for="(edu, index) in profile.education" :key="index" class="mb-3 border p-2 rounded">
                                <label for="">Degree</label>
                                <b-form-input
                                    v-model="edu.degree"
                                    placeholder="Degree"
                                    class="mb-2"
                                ></b-form-input>
                                <label for="">Institute</label>
                                <b-form-input
                                    v-model="edu.institute"
                                    placeholder="Institute"
                                    class="mb-2"
                                ></b-form-input>
                                <label for="">Start Date</label>
                                <b-form-input
                                    type="date"
                                    v-model="edu.start_date"
                                    placeholder="Start Date"
                                    class="mb-2"
                                ></b-form-input>
                                <label for="">End Date</label>
                                <b-form-input
                                    type="date"
                                    v-model="edu.end_date"
                                    placeholder="End Date"
                                    class="mb-2"
                                ></b-form-input>

                                <b-button size="sm" variant="danger" @click="removeEducation(index)">Remove</b-button>
                            </div>

                            <b-button size="sm" variant="success" @click="addEducation">Add Education</b-button>
                        </b-form-group>

                        <b-button type="submit" variant="primary" class="mt-2" style="margin-right: 2px;" @click="createChanges(profile)" block>Save Changes</b-button>
                        <b-button variant="primary" @click="$router.push({ name: 'profile.page' })" class="mt-2">Back to Profile</b-button>

                    <b-alert
                        v-if="message"
                        variant="success"
                        show
                        class="mt-3 text-center"
                    >
                        {{ message }}
                    </b-alert>

                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import {useProfileList} from "@/pages/useProfileList.js";

export default {
    data() {
        return {
            profile: {
                id: null,
                name: null,
                gender: null,
                hobbies: [],
                image: null,
                education: []
            },
            genderOptions: ["male", "female"],
            avatarPreview: null,
            hobbiesOptions: ['travelling', 'hiking', 'reading'],
            avatarFile: null,
            message: ""
        };
    },
    methods: {
        addEducation() {
            this.profile.education.push({
                degree: '',
                institute: '',
                start_date: '',
                end_date: ''
            });
        },
        removeEducation(index) {
            this.profile.education.splice(index, 1);
        },
    },
    setup() {

        const {
            createChanges,
            avatarFile,
            avatarPreview,
            onFileChange
        } = useProfileList()

        return {
            createChanges,
            avatarFile,
            avatarPreview,
            onFileChange
        }
    }
};
</script>

<style scoped>
</style>
