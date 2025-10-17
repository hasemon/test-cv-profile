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

                    <template v-if="isManage === 'true' || isManage === true">
                        <b-button variant="primary" @click="$router.push({ name: 'profile.edit', params: { id: profileData.id } })" v-if="hasProfile"> Edit Profile</b-button>
                        <b-button variant="primary" @click="$router.push({ name: 'profile.create' })" v-else>Create Profile</b-button>
                        <b-button variant="danger" style="margin-left:2px" @click="confirmDelete(profileData.id)" v-if="hasProfile">Delete Profile</b-button>
                    </template>
                    <template v-if="isManage === 'false' || !isManage">
                        <div class="comments-section mt-4">
                            <h5>Comments</h5>

                            <hr>
                            <div v-for="comment in comments" :key="comment.id" class="mb-3 border-bottom pb-2">
                                <strong>{{ comment.user ? comment.user.name : 'Anonymous' }}</strong>
                                <p>{{ comment.comment_text }}</p>
                                <b-img
                                    v-if="comment.comment_image"
                                    :src="`${comment.comment_image}`"
                                    fluid
                                    rounded
                                    style="max-height: 200px;"
                                ></b-img>
                                <small class="text-muted">{{ formatDate(comment.created_at) }}</small>
                            </div>
                            <hr>
                            <!-- Add Comment -->
                            <b-form @submit.prevent="addComment">
                                <b-form-textarea
                                    v-model="newComment.text"
                                    placeholder="Write a comment..."
                                    rows="2"
                                ></b-form-textarea>

                                <b-form-file
                                    v-model="newComment.image"
                                    accept="image/*"
                                    class="mt-2"
                                    placeholder="Attach an image"
                                ></b-form-file>

                                <b-button type="submit" variant="primary" class="mt-2">Post Comment</b-button>
                            </b-form>
                            <hr>
                        </div>

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
import Swal from "sweetalert2";
import router from "../router.js";
export default {
    computed: {
        HTTP() {
            return HTTP
        }
    },
    data() {
        return {
            comments: [],
            newComment: {
                text: '',
                image: null
            },
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
        formatDate(date) {
            const d = new Date(date);

            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();

            let hours = d.getHours();
            const minutes = String(d.getMinutes()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            const strTime = `${hours}:${minutes} ${ampm}`;

            return `${day}-${month}-${year} ${strTime}`;
        },
        fetchComments() {
            axios.get(`${HTTP.baseURL}/api/profile/${this.profileData.id}/comments`)
                .then(res => {
                    const { status, data, message } = res.data
                    if (status) {
                        this.comments = data.comments;
                    }
                });
        },

        addComment() {
            const formData = new FormData();
            formData.append('comment_text', this.newComment.text);
            if (this.newComment.image) {
                formData.append('comment_image', this.newComment.image);
            }

            axios.post(`${HTTP.baseURL}/api/profile/${this.profileData.id}/comments`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then(res => {
                const { status, data } = res.data
                if (status) {
                    this.comments.unshift(data.comment); // add to top
                    this.newComment.text = '';
                    this.newComment.image = null;
                    return
                }
            });
        },
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
                    if (this.hasProfile) {
                        this.fetchComments();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Failed to fetch profile");
                });
        },
        confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action will permanently delete your profile!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`${HTTP.baseURL}/api/profile/${id}`)
                        .then(res => {
                            const { status, message } = res.data
                            if (status) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your profile has been removed successfully.",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                });

                                router.push({ name: 'profile.create' });
                                return
                            }

                            alert(message)
                        })
                        .catch((error) => {
                            console.error(error);
                            Swal.fire({
                                title: "Error!",
                                text: "Failed to delete profile. Please try again.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                }
            });
        }

    },
    created() {
        this.fetchProfile();
    },

}
</script>
