<template>
    <div class="d_column">
        <div class="d_project_box">
            <div class="d_img_box">
                <img v-if="!storage.logo" :src="'assets/img/folder.png'">
                <img v-else :src="storage.image_path+'original/'+ storage.logo" >
                <div class="d_hover">
                    <div class="d_hover_content">
                        <div class="dropdown">
                        <b-dropdown  text="">
                            <b-dropdown-item v-on:click="model_show_edit_storage(storage.id,storage.name)" >Edit</b-dropdown-item>
                            <!-- <b-dropdown-item v-on:click="model_show(storage.id)">Share Album</b-dropdown-item> -->
                            <!-- <b-dropdown-item v-on:click="copy_storage(storage.id)" >Duplicate Album</b-dropdown-item> -->
                            <b-dropdown-item v-on:click="delete_storage(storage.id)">Delete</b-dropdown-item>
                            <b-dropdown-item v-on:click="download_storage(storage.id)">Download</b-dropdown-item>
                        </b-dropdown>
                        </div>
                        <a href="javascript:void(0)" class="btn" v-on:click="hite(storage.id)">View Storage</a>
                        <div class="project-info">
                            <p>{{ storage.total_img }} photos</p>
                            <p>{{ storage.total_vid }} video</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d_content_data clearfix"> 
                <div class="d__content_data_l">
                    <h6>{{ storage.name }}</h6>
                </div>
                <div class="d__content_data_r">
                    <div class="d_date">{{ storage.date }}</div>
                </div>
            </div>
        </div>

        <modal :name="'model-show-edit-storage'+storage.id" height="auto" :scrollable="true" draggable=".window-header">
            <div class="window-header">
            <div class="form_content_box">
                <!-- <div class="form_logo"><img src="../../../img/datacuda.png"></div> -->
                <flash-message class="myCustomClass"></flash-message>
                <button type="button" class="close" aria-label="Close"  @click="model_hide_edit_storage(storage.id)"> &times; </button>

                <h2>Update Storage</h2>
                <div class="form-group">
                    <input type="text" name = "storage_name" class="form_cus form-control" id="storage_name" placeholder="Enter your storage name" v-model="storage_name" v-validate="'required'">
                    <div v-if="errors.has('storage_name')">
                        {{ errors.first('storage_name') }}
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn green_btn btn-block mb-3" @click="updateStorage(storage.id)">UPDATE STORAGE</button>
                          </div>
            </div>
            </div>
        </modal>

    </div>
</template>
<script>
    export default {
        data() {
            let storage = '';
            return {
                storage: '',
                storage_name:'',
            }
        },
        props: {
            storage: Object
        },
        methods: {
            shuffle() {
                //.tweets = _.shuffle(this.tweets)
            },
            hite(id)
            {
                this.$router.push('/storage/'+id);
            },
            model_show_edit_storage(id,sname){
                this.storage_name = sname;
                this.$modal.show('model-show-edit-storage'+id);
                
            },
             model_hide_edit_storage(id){
                this.$modal.hide('model-show-edit-storage'+id);
            },
            updateStorage(id){
                console.log("update storage",id,this.storage_name);
                let data = {
                    storage_name: this.storage_name,
                    id: id,
                };

                axios
                    .post("/api/update_storage", data)
                    .then(( response ) => {
                        if(response.data.status == 201 ){
                            this.flash(response.data.message, "success");
                            this.$router.push('/storage/'+ response.data.storage_id);
                        }else{
                            this.flash(response.data.error.storage_name[0], "error");
                        }
                        
                    })
                    .catch(({ data }) => {
                        this.flash(data.data.message, "success");
                        
                    });
                this.$modal.hide('model-show-edit-storage'+id);
                //this.getUserProjects();

            },
            delete_storage (id) {
                //console.log(id);
                let data = {
                    id: id
                };
                axios
                    .post('/api/soft_delete_storage', data)
                    .then(( response ) => {
                        //console.log(response);
                        this.$parent.getUserStorage();
                         this.flash('Storage Deleted !', 'success');
                    })
                    .catch(( response ) => {
                        this.$parent.getUserStorage();
                       /// console.log('not deleted');
                         this.flash('Storage not Deleted', 'error');
                    });
            },
            copy_storage(){

            },
            download_storage(id){
                var id = id;
                let data = {
                    id: id,
                    id_type:'e',
                };
                axios
                    .post('/api/user_download_storage', data)
                    .then(( response ) => {
                        var url = response.data.data.url;
                        window.location.href = url;
                    })
                    .catch(( response ) => {
                        //console.log(response);
                    });
            }
        },

        created() {
            //this.storagePrice();
            //console.log(tweets);
            //console.log("pravin",this.storage);
        }
    }

</script>
