
import {ref} from "@vue/composition-api";
import {HTTP} from "@/http.js";
import axios  from "axios";
import router from "@/router.js";

export const useProfileList = () => {
    const hasProfile = ref(false)
    const blankProfile = {
        id:null,
        name: null,
        gender: null,
        hobbies: [] ,
        image: null,
        education: []
    }
    const profile =ref(JSON.parse(JSON.stringify(blankProfile)))
    const profileData =ref(JSON.parse(JSON.stringify(blankProfile)))
    const avatarFile = ref(null);
    const avatarPreview = ref(null);

    const fetchProfile = () => {
        axios.get(`${HTTP.baseURL}/api/profile`)
            .then(response => {
                const {status, data} = response.data
                    hasProfile.value = !!data.name

                profileData.value.id = data.id ?? null
                profileData.value.name = data.name ?? null
                profileData.value.gender = data.gender ?? null
                profileData.value.hobbies = data.hobbies ?? []
                profileData.value.image = data.image ?? null
                console.log(profileData.value)
            }).catch(err => {
            if (err.response) {
                console.error('Server responded with error:', err.response.data);
                alert(`Error: ${err.response.data.message || 'Something went wrong!'}`);
            } else if (err.request) {
                console.error('No response received:', err.request);
                alert('Network error: Could not reach the server.');
            } else {
                console.error('Error setting up request:', err.message);
                alert(`Error: ${err.message}`);
            }
        });
    }

    const onFileChange = (event) => {
        const file = event.target.files[0];
        if (file) {
            avatarFile.value = file;
            avatarPreview.value = URL.createObjectURL(file);
        }
    };

    const updateChanges = (profileData) => {
        const formData = new FormData();
        formData.append("id", profileData.id);
        formData.append("name", profileData.name);
        formData.append("gender", profileData.gender);
        formData.append("hobbies", JSON.stringify(profileData.hobbies));
        formData.append("education", JSON.stringify(profileData.education));
        if (avatarFile.value)
            formData.append("image", avatarFile.value);
        axios.post('/api/profile', formData)
            .then(res => {
                const { status, data, message } = res.data

                if (!status) {
                    alert(message)
                    return
                }

                alert(message || "Profile updated successfully!");

                router.push({ name: 'profile.page' });
            }).catch(err => {
            console.error(err);
            alert("Something went wrong!");
        });
    }
    const createChanges = (profile) => {
        const formData = new FormData();
        formData.append("name", profile.name);
        formData.append("gender", profile.gender);
        formData.append("hobbies", JSON.stringify(profile.hobbies));
        formData.append("education", JSON.stringify(profile.education));
        if (avatarFile.value)
            formData.append("image", avatarFile.value);
        axios.post('/api/profile', formData)
          .then(res => {
             const { status, data, message } = res.data

              if (!status) {
                  alert(message)
                  return
              }

              alert(message || "Profile updated successfully!");

              router.push({ name: 'profile.page' });
          }).catch(err => {
            console.error(err);
            alert("Something went wrong!");
        });
    }

    return {
        blankProfile,
        hasProfile,
        fetchProfile,
        updateChanges,
        createChanges,
        profile,
        profileData,
        avatarFile,
        avatarPreview,
        onFileChange
    }
}
