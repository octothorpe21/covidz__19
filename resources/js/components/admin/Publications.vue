<template>
<div>
    <div class="card bg-card">
        <div class="card-header flex justify-content-between align-items-center">
            <h1 v-text="$route.name"></h1>
            <button @click="$modal.show('add-publication-modal')" type="button" class="btn btn-sm btn-success font-weight-bold">Add Publication</button>
        </div>
        <div class="table-responsive card-body">
            <div>
                <table class="table table-bordered">
                    <thead class="text-success font-weight-bold">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Likes</th>
                            <th>Dislikes</th>
                            <th>Source</th>
                            <th>Date</th>
                            <!-- <th>Professions</th>
                            <th>Maladies</th>
                            <th>Wilayas</th> -->
                            <th>Other</th>
                            <th>Cover</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pub in publications" :key="pub.id">
                            <td v-text="pub.id"></td>
                            <td v-text="pub.title"></td>
                            <td v-text="pub.likes"></td>
                            <td v-text="pub.dislikes"></td>
                            <td><a class="btn btn-sm btn-secondary font-weight-bold" :href="pub.source" target="_blank">Go to Source</a></td>
                            <!-- <td><span v-for="job in pub.jobs" :key="job.id" class="btn-dark btn btn-sm" v-text="job.name"></span></td>
                            <td><span v-for="job in pub.diseases" :key="job.id" class="btn-dark btn btn-sm" v-text="job.name"></span></td>
                            <td><span v-for="job in pub.wilayas" :key="job.id" class="btn-dark btn btn-sm" v-text="job.name"></span></td> -->
                            <td><span class="btn btn-sm btn-warning fon-weight-bold" v-text="moment(pub.created_at).format('DD-MM-YYYY')"></span></td>
                            <td>
                                <button class="btn btn-sm btn-light font-weight-bold" @click="showModal('see-publication-modal',pub)">Show Details</button>
                            </td>
                            <td>
                                <a href="" data-toggle="tooltip" data-placement="bottom" title="View profile">
                                    <img class="avatar" :src='"/storage/" + pub.image' alt="">
                                </a>
                            </td>
                            <td>
                                <div>
                                    <button @click.prevent="showModal('edit-publication-modal',pub)" type="button" class="btn btn-sm btn-primary">Edit</button>
                                    <button @click.prevent="showModal('delete-publication-modal',pub)" type="button" class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>

            </div>
        </div>
        <div class="card-footer">
            <div class=" flex justify-content-between align-items-center">
                <div class="my-4">
                    <ul class="pagination pagination-md justify-content-center text-center">
                        <li class="page-item" :class="from === 1 ? 'disabled' : ''">
                            <a class="page-link" @click="previousPage">
                                Previous
                            </a>
                        </li>
                        <li class="page-link" style="background-color: inherit">
                            {{ currentPage }} of {{ pages }}
                        </li>
                        <li class="page-item" :class="to === total ? 'disabled' : ''">
                            <a class="page-link" @click="nextPage">
                                Next
                            </a>
                        </li>
                    </ul>
                </div>
                <button type="button" @click.prevent="$modal.show('delete-publication-modal')" class="btn btn-sm btn-danger">Delete All</button>
            </div>
        </div>
    </div>

    <!-- Delete Publication modal -->
        <modal name="delete-publication-modal" height="auto" width="750px" classes="text-light bg-secondary">
            <div class="card bg-dark">
                <div class="card-body">
                    <h5 class="alert font-size-lg m-auto text-center">Are You Sure you want to delete <span class="font-weight-bold text-warning">{{title}}</span> ?</h5>
                </div>
                <div class="card-footer">
                    <div class="flex align-items-center justify-content-between">
                        <button type="button" @click="$modal.hide('delete-publication-modal')" class="btn btn-sm btn-danger">Cancel</button>
                        <button type="button" @click='deletePub(modalPub.id)' class="btn btn-sm btn-success">Delete</button>
                    </div>
                </div>
            </div>
        </modal>
    <!-- See Tags Model -->
    <modal name="see-publication-modal" height="auto" width="750px" classes="text-light bg-secondary">
        <div class="card bg-dark">
            <div class="card-header">
                <h4 class="font-weight-bold" v-text="modalPub.title"></h4>
            </div>
            <div class="card-body table-responsive">
                 <table class="table table-bordered">
                    <thead class="text-success font-weight-bold">
                        <tr>
                            <th>Professions</th>
                            <th>Maladies</th>
                            <th>Wilayas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span v-for="job in modalPub.jobs" :key="job.id" class="btn-info btn btn-sm m-1" v-text="job.name"></span></td>
                            <td><span v-for="job in modalPub.diseases" :key="job.id" class="btn-info btn btn-sm m-1" v-text="job.name"></span></td>
                            <td><span v-for="job in modalPub.wilayas" :key="job.id" class="btn-info btn btn-sm m-1" v-text="job.name"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="flex align-items-center justify-content-end">
                    <button type="button" @click="$modal.hide('see-publication-modal')" class="btn btn-sm btn-danger">Close</button>
                    <!-- <button type="submit" class="btn btn-sm btn-success">Add</button> -->
                </div>
            </div>
        </div>
    </modal>
    <!-- Add Publications Modal -->
    <modal name="add-publication-modal" height="auto" width="850px" classes="text-dark bg-light">
        <div>

            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold">Add Publication</h4>
                </div>
                <form action="/publications/create" method="POST" @submit.prevent="addPub">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="row mx-1">
                                <input dir="auto" type="text" class=" form-control text-dark mb-3" placeholder="Title ..." v-model="title">
                                <!-- <span class=" alert text-danger" v-if="errors" v-text="form.errors.errors.errors.tagName[0]"></span> -->
                            </div>
                            <div class="row mx-1">
                                <!-- <div class="col-md-6"> -->
                                    <input dir="auto" type="text" class=" form-control text-dark mb-3" placeholder="Source ..." v-model="sources">

                            </div>
                        

                            <div class="row">
                                <textarea dir="auto" rows="6" type="text" class=" form-control mb-3 mx-3" placeholder="Body ..." v-model="body"></textarea>
                                <!-- <span class=" alert text-danger" v-if="errors" v-text="form.errors.errors.errors.tagName[0]"></span> -->
                            </div>
                            <div class="row mx-1">
                                 <div class="flex justify-content-between align-items-center p-2" style="width: 100%">
                                <button type="button" class="btn" data-toggle="tooltip" data-placement="bottom" title="Select a Cover Image">
                                    <label for="path" class="flex" style="margin-bottom: 0;">
                                        <div>
                                            <svg width="1.5625em" height="1.5em" viewBox="0 0 17 16" class="bi bi-image-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15.002 9.5V13a1 1 0 0 1-1 1h-12a1 1 0 0 1-1-1v-1zm5-6.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                            </svg>
                                        </div>
                                    </label>
                                </button>
                                <input type="file" name="path" id="path" @change="newCover" style="display: none;">
                                <img :src="imgPreview" alt="" class="img-preview rounded-lg" width="150px">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3 mx-1">
                            <!-- <select name="" v-model="wilayas" id="" class="form-control mb-3" multiple>
                                <option value="" selected disabled>Wilayas...</option>
                                <option v-for="category in $store.state.wilayas" :key="category.id" :value="category.id">{{category.name}}</option>
                            </select> -->
                                <multiselect 
                                        v-model="wilaya" 
                                        tag-placeholder="Add Wilaya" 
                                        placeholder="Add Wilaya" 
                                        label="name" track-by="id" 
                                        :options="$store.state.wilayas" 
                                        :multiple="true" 
                                        :taggable="true" 
                                        >

                                    </multiselect>
                        </div>
                        <div class="row mb-3 mx-1">
                                <!-- <select name="" v-model="diseases" id="" class="form-control bg-secondary text-light mb-3" multiple>
                                    <option value="" selected disabled>Diseases...</option>
                                    <option v-for="wilaya in $store.state.diseases" :key="wilaya.id" :value="wilaya.id">{{wilaya.name}}</option>
                                </select> -->
                                      <multiselect 
                                            v-model="disease" 
                                            tag-placeholder="Add Maladies" 
                                            placeholder="Add Maladie" 
                                            label="name" track-by="id" 
                                            :options="$store.state.diseases" 
                                            :multiple="true" 
                                            :taggable="true" 
                                            >

                                      </multiselect>
                            </div>
                            <div class="row mb-3 mx-1">
                                <!-- <select name="" v-model="jobs" id="" class="form-control mb-3" multiple>
                                    <option value="" selected disabled>Jobs...</option>
                                    <option v-for="wilaya in $store.state.jobs" :key="wilaya.id" :value="wilaya.id">{{wilaya.name}}</option>
                                </select> -->
                                 <multiselect 
                                            v-model="job" 
                                            tag-placeholder="Add Jobs" 
                                            placeholder="Add Jobs" 
                                            label="name" track-by="id" 
                                            :options="$store.state.jobs" 
                                            :multiple="true" 
                                            :taggable="true"
                                            trackBy="id"
                                            >

                                      </multiselect>
                                <!-- <input type="text" class=" form-control bg-secondary text-light mb-3" placeholder="Address ..." v-model="address"> -->
                                <!-- <span class=" alert text-danger" v-if="errors" v-text="form.errors.errors.errors.tagName[0]"></span> -->
                            </div>
                        </div>
                                            </div>
                                                            <div class="card-footer">
                        <div class="flex align-items-center justify-content-between">
                            <button type="button" @click="$modal.hide('add-publication-modal')" class="btn btn-sm btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-success">Add</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </modal>
    <!-- Edit Publications Modal -->
    <modal name="edit-publication-modal" height="auto" width="750px" classes="text-dark bg-light">
        <div>

            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold">Edit Publication</h4>
                </div>
                <form action="/publications/create" method="POST" @submit.prevent="editPub">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="row mx-1">
                                <input dir="auto" type="text" class=" form-control text-dark mb-3" placeholder="Title ..." v-model="title">
                                <!-- <span class=" alert text-danger" v-if="errors" v-text="form.errors.errors.errors.tagName[0]"></span> -->
                            </div>
                            <div class="row mx-1">
                                <!-- <div class="col-md-6"> -->
                                    <input dir="auto" type="text" class=" form-control text-dark mb-3" placeholder="Source ..." v-model="sources">

                            </div>
                        

                            <div class="row">
                                <textarea dir="auto" rows="6" type="text" class=" form-control mb-3 mx-3" placeholder="Body ..." v-model="body"></textarea>
                                <!-- <span class=" alert text-danger" v-if="errors" v-text="form.errors.errors.errors.tagName[0]"></span> -->
                            </div>
                            <div class="row mx-1">
                                 <div class="flex justify-content-between align-items-center p-2" style="width: 100%">
                                <button type="button" class="btn" data-toggle="tooltip" data-placement="bottom" title="Select a Cover Image">
                                    <label for="path" class="flex" style="margin-bottom: 0;">
                                        <div>
                                            <svg width="1.5625em" height="1.5em" viewBox="0 0 17 16" class="bi bi-image-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15.002 9.5V13a1 1 0 0 1-1 1h-12a1 1 0 0 1-1-1v-1zm5-6.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                            </svg>
                                        </div>
                                    </label>
                                </button>
                                <input type="file" name="path" id="path" @change="newCover" style="display: none;">
                                <img :src="imgPreview" alt="" class="img-preview rounded-lg" width="150px">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3 mx-1">
                            <!-- <select name="" v-model="wilayas" id="" class="form-control mb-3" multiple>
                                <option value="" selected disabled>Wilayas...</option>
                                <option v-for="category in $store.state.wilayas" :key="category.id" :value="category.id">{{category.name}}</option>
                            </select> -->
                                <multiselect 
                                        v-model="wilaya" 
                                        tag-placeholder="Add Wilaya" 
                                        placeholder="Add Wilaya" 
                                        label="name" track-by="id" 
                                        :options="$store.state.wilayas" 
                                        :multiple="true" 
                                        :taggable="true" 
                                        >

                                    </multiselect>
                        </div>
                        <div class="row mb-3 mx-1">
                                <!-- <select name="" v-model="diseases" id="" class="form-control bg-secondary text-light mb-3" multiple>
                                    <option value="" selected disabled>Diseases...</option>
                                    <option v-for="wilaya in $store.state.diseases" :key="wilaya.id" :value="wilaya.id">{{wilaya.name}}</option>
                                </select> -->
                                      <multiselect 
                                            v-model="disease" 
                                            tag-placeholder="Add Maladies" 
                                            placeholder="Add Maladie" 
                                            label="name" track-by="id" 
                                            :options="$store.state.diseases" 
                                            :multiple="true" 
                                            :taggable="true" 
                                            >

                                      </multiselect>
                            </div>
                            <div class="row mb-3 mx-1">
                                <!-- <select name="" v-model="jobs" id="" class="form-control mb-3" multiple>
                                    <option value="" selected disabled>Jobs...</option>
                                    <option v-for="wilaya in $store.state.jobs" :key="wilaya.id" :value="wilaya.id">{{wilaya.name}}</option>
                                </select> -->
                                 <multiselect 
                                            v-model="job" 
                                            tag-placeholder="Add Jobs" 
                                            placeholder="Add Jobs" 
                                            label="name" track-by="id" 
                                            :options="$store.state.jobs" 
                                            :multiple="true" 
                                            :taggable="true"
                                            trackBy="id"
                                            >

                                      </multiselect>
                                <!-- <input type="text" class=" form-control bg-secondary text-light mb-3" placeholder="Address ..." v-model="address"> -->
                                <!-- <span class=" alert text-danger" v-if="errors" v-text="form.errors.errors.errors.tagName[0]"></span> -->
                            </div>
                        </div>
                                            </div>
                                                            <div class="card-footer">
                        <div class="flex align-items-center justify-content-between">
                            <button type="button" @click="$modal.hide('edit-publication-modal')" class="btn btn-sm btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-success">Edit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </modal>
</div>
</template>
<style scoped>
    .multiselect {
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        color: #343a40 !important;
    }
    .multiselect__tag {
        font-size: 12px;
        padding: 4px 20px 4px 5px;
    }
    input.form-control, select.form-control, option:disabled{
        background: #fff;
        border-radius: 5px;
        color: #343a40 !important;
    }
    input::placeholder, textarea::placeholder {
        color: #343a40 !important;
    }
    .multiselect__option {
        padding: 8px;
        min-height: 20px;
        line-height: 12px;
    }
    .row {
        height: inherit;
    }
    textarea {
        resize: none;
    }
</style>
<script>
import moment from 'moment'
export default {
    data() {
        return {
            publications: [],
            sources: "",
            // values: [],
            cover: '',
            // selected: null,
            title: '',

            disease: [],
            diseases: [],

            wilaya: [],
            wilayas: [],

            job: [],
            jobs: [],

            body: '',
            // options: '',
            imgPreview: '',
            data: new FormData(),
            errors: '',
            options: "",
            perPage: 4,
            currentPage: '',
            page: 1,
            from: '',
            to: '',
            next: '',
            prev: '',
            total: '',
            pages: '',
            modalPub: '',
            selectedTags: [],
        }
    },
    beforeMount() {
        // this.$Progress.start();
    },
    mounted() {
        this.options = [{
                language: 'JavaScript',
                library: 'Vue.js'
            },
            {
                language: 'JavaScript',
                library: 'Vue-Multiselect'
            },
            {
                language: 'JavaScript',
                library: 'Vuelidate'
            }
        ];
        this.callAPI('get', '/admin/publications/get')
            .then(response => {
                this.publications = response;
                this.afterRequest(response);
            })
            .catch(error => console.log(errors))
    },
    methods: {
        customLabel(option) {
            return option.name;
        },
        setData: (disease, wilaya, job) => {

            let diseaseData = [];
            let jobData = [];
            let wilayaData = [];
           
            disease.map((m) => {
                diseaseData.push(m.id);
            });
            wilaya.map((w) => {
                wilayaData.push(w.id);
            });
            job.map((j) =>{
                jobData.push(j.id);
            });       
            return [
                wilayaData, jobData, diseaseData
            ];
        },
        newCover(event) {
            let files = event.target.files;
            console.log("file: " + files[0]);
            if (files.length) this.cover = files[0];
            console.log(this.cover)
            this.imgPreview = URL.createObjectURL(event.target.files[0]);
        },
        afterRequest(data) {
            this.role = '';
            this.editedUser = {};
            // this.users = data.users;
            this.publications = data.data;
            this.currentPage = data.current_page;
            this.from = data.from;
            this.perPage = data.per_page;
            this.next = data.next_page_url;
            this.prev = data.prev_page_url;
            this.to = data.to;
            this.total = data.total;
            this.pages = data.last_page;
        },
         showModal(modal, pub) {
            this.$modal.show(modal);
            this.modalPub = pub;
            this.title = pub.title;
            this.body = pub.body;
            this.disease = pub.diseases;
            this.job = pub.jobs;
            this.wilaya = pub.wilayas;
            this.sources = pub.source;
            // this.cover = pub.cover;
            this.imgPreview = '/storage/' + pub.image;
        },

        erase(){
            this.title = '';
            this.body = '';
            this.diseases = '';
            this.disease = '';
            this.job = '';
            this.jobs = '';
            this.wilaya = '';
            this.wilayas = '';
            this.sources = '';
            this.cover = '';
            this.imgPreview = '';
        },

        addPub() {
            let wilayas, jobs, diseases;
            this.$Progress.start();
            [wilayas, jobs, diseases] = this.setData(this.disease, this.wilaya, this.job);
            

            this.data.set('title', this.title);
            this.data.set('body', this.body);
            this.data.set('diseases', diseases);
            this.data.set('wilayas', wilayas);
            this.data.set('jobs', jobs);
            this.data.set('image', this.cover);
            this.data.set('_method', "patch");
            this.data.set('source', this.sources);
            this.callAPI('post', '/admin/publications/create', this.data)
                .then(responce => {
                    console.log(responce);
                    this.callAPI('get', '/admin/publications/get')
                        .then(response => {
                            this.publications = response;
                            this.afterRequest(response);
                        })
                        .catch(error => console.log(errors))
                })
                .then(() => {
                    this.erase();
                    this.$modal.hide('add-publication-modal')
                })
                .catch(error => console.log(error))
            this.$Progress.finish();
        },
        editPub(){
            let wilayas, jobs, diseases;
            this.$Progress.start();
            [wilayas, jobs, diseases] = this.setData(this.disease, this.wilaya, this.job);
            this.data.set('title', this.title);
            this.data.set('body', this.body);
            this.data.set('diseases', diseases);
            this.data.set('wilayas', wilayas);
            this.data.set('jobs', jobs);
            this.data.set('image', this.cover);
            this.data.set('_method', "patch");
            this.data.set('source', this.sources);
            this.callAPI('post', `/admin/publications/${this.modalPub.id}/update`, this.data)
                .then(responce => {
                    console.log(responce);
                    this.callAPI('get', '/admin/publications/get')
                        .then(response => {
                            this.publications = response;
                            this.afterRequest(response);
                        })
                        .catch(error => console.log(errors))
                })
                .then(() => {
                    this.$modal.hide('edit-publication-modal')
                    this.erase();
                })
                .catch(error => console.log(error))
                this.$Progress.finish();
            
        }, 
        deletePub(id){
            this.$Progress.start();
            this.callAPI('post', `/admin/publications/${id}/delete`)   
            .then(responce => {
                    console.log(responce);
                    this.callAPI('get', '/admin/publications/get')
                        .then(response => {
                            this.publications = response;
                            this.afterRequest(response);
                        })
                        .catch(error => console.log(errors))
                })
                .then(() => {
                    this.erase();
                    this.$modal.hide('delete-publication-modal')
                })
                .catch(error => console.log(error))
            this.$Progress.finish();
        }
    },
    computed: {

    },
}
</script>
