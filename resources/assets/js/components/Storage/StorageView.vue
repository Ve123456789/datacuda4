<template>
  <div>
    <div v-if="loading" class="main_model_box">
      <div class="model_box loader"></div>
    </div>
    <section class="margin_top_for_header"></section>
    <!-- Dashboard Project -->
    <section class="dashboard__filter filterSec">
      <div class="d_container container">
        <div class="file-upload">
          <div class="form-group btnSec">
            <div class="row">
              <div class="col-md-8 col-lg-3 my-5x header-plans">
                <p>
                  <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                  Total Image Size :
                  {{storage_size.value}}{{storage_size.type}}
                </p>
              </div>
                <div class="col-md-4">
						<router-link to="/storage" :style="{'text-transform':'none'}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back To Storage</router-link>
              </div>
            </div>
          </div>
        </div>
        <!-- <flash-message class="myCustomClass"></flash-message> -->
      </div>
    </section>
    <section class="project_post_wrapper grey_bg detailPage">
      <div class="container-fluid clearfix">
        <div class="row clearfix">
          <div class="col-md-12 col-lg-3">
            <aside class="side_bar">
              <div class="project_profile">
                <span v-if="medias[0]">
                  <img
                    v-bind:src="image_path+'medium/'+ medias[0].filename"
                    v-img:name
                    class="project_profile_img"
                    width="100%"
                  />
                </span>
                <span v-else>
                  <img  :src="'assets/img/dummy_image.jpg'" class="project_profile_img" width="100%" >
                </span>
                <div class="project_content_wrapper">
                  <div class="clearfix">
                    <div class="p_left_content">
                      <h3>{{ storage_data.storage_name }}</h3>
                      <p>{{ storage_data.storage_date }}</p>
                    </div>

                    <div class="p_right_content" id="project_edit_btn">
                      <!-- <a href="javascript:void(0)" v-on:click="model_show_edit_storage(storage_data.id,storage_data.name)" >
                        <img src="../../../img/edit.svg" class="edit_icon" />
                      </a>
                      <p>Preview</p> -->
                    </div>
                  </div>
                </div>
                <nav>
                  <ul class="project_profile_nav">
                    <!-- <li>
                      <a href="javascript:void(0)" id="tabs1" class="active" v-on:click="tabs(1)">
                        <div class="img__icon">
                          <img src="../../../img/upload.png" />
                        </div>
                        <span>Upload files</span>
                      </a>
                    </li> -->
                  </ul>
                </nav>
              </div>
            </aside>
          </div>
          <div class="col-md-12 col-lg-9">
            <div id="tabs_show1">
              <div class="additional__iteam">
                <div class="file-upload customBox">
                  <div class="form-group">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-8 attach">
                          <h2>Attached</h2>
                        </div>
                      </div>

                      <div class="row detailSec">
                        <div class="col-md-12 col-lg-8 ve-scroll" id="style-3">
                          <div class="force-overflow">
                            <StorageFiles v-for="media in medias" :media="media" :key="media.id"></StorageFiles>
                            <div class="col-md-6 detailList" v-for="(attachment, index) in file">
                              <div class="thumbnail thumbnailSecNotUploaded">
                                <div class="imgThumb">
                                  <img
                                    v-bind:ref="'image'+parseInt( index )"
                                    class="img-rounded"
                                    width="100%"
                                  />
                                </div>
                                <div class="caption">
                                  <p class="proName">
                                    <!--<span class="proDate">12/08/2017</span>-->
                                    {{ attachment.name.substring(0,10) + '...' }}
                                  </p>
                                  <p class="listBott">
                                    <span class="fileSize">
                                      {{ Number((attachment.size / 1024 / 1024).toFixed(1)) }}
                                      <span>mb</span>
                                    </span>
                                    <span class="fileRename">
                                      <i
                                        class="fa fa-trash-o"
                                        aria-hidden="true"
                                        @click="removeAttachment(attachment)"
                                      ></i>
                                    </span>
                                  </p>
                                  <!--<p class="payment"><span class="amt">$ <input type="number" :id="'image_amount_e'+media.id" :value="media.amount" readonly="readonly" v-on:focusout="amout_edit(media.id,media.amount)"></span></p>-->
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="force-overflow"></div>
                        </div>
                        <div class="col-md-12 col-lg-4 dragSec" id="fileDrag">
                          <div class="sec sec-select">
                            <img src="/assets/img/upload.svg" class="uploa_d_icon" />
                            <h3>Drag & Drop</h3>
                            <span>
                              your file here or
                              <label class="btn_browse" for="file">Browse Files</label>
                            </span>
                            <input
                              type="file"
                              id="file"
                              multiple="multiple"
                              @change="uploadFieldChange"
                            />
                            <div class="threesixty-wrapper">
                              <div class>
                                <input type="checkbox" v-model="img_360" value="1" />
                              </div>
                              <div class>
                                <p>360 Degree Image</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Share link Modal -->
    <div
      class="modal fade project-modal"
      id="shareLinkModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row p-0 m-0">
              <div
                class="left-wrapper m-0"
                style="background:url(./assets/img/payment_bg.png) center; background-repeat: no-repeat; background-size: cover;"
              >
                <div class="left-content">
                  <img class="img-responsive" src="../../../img/rocket.svg" alt />
                  <h2>You're done file sent successful!</h2>
                </div>
              </div>
              <div class="right-wrapper">
                <button type="button" class="close mr-2" v-on:click="closeSuccessPopup">&times;</button>
                <div class="right-content">
                  <h4 class="mb-4">Copy your download link</h4>
                  <div class="form-group col-md-12">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="link"
                      :value="share_link"
                      id="share_link_copy"
                    />
                  </div>
                  <button type="button" class="btn mt-3 green_btn" v-on:click="copyLinkData">
                    <span aria-hidden="true">Copy Link</span>
                  </button>
                  <!-- <div class="mt-3 pass">
                                    <p><span class="pr-2 ">Password</span> {{ link_password }}</p> 
                  </div>-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- //// Share link Modal -->

    <!-- Send mail Modal -->
    <div
      class="modal fade project-modal"
      id="sendMailModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row p-0 m-0">
              <div
                class="left-wrapper m-0"
                style="background:url(./assets/img/payment_bg.png) center; background-repeat: no-repeat; background-size: cover;"
              >
                <div class="left-content">
                  <img class="img-responsive" src="../../../img/rocket.svg" alt />
                  <h2>You're done file sent successful!</h2>
                </div>
              </div>
              <div class="right-wrapper">
                <div class="right-content">
                  <h4
                    class="mb-4"
                  >You can monitor when your files are viewed and payment recieved on your dashboard</h4>
                  <button type="button" class="btn mt-3 green_btn" v-on:click="returnDashboard()">
                    <span aria-hidden="true">Return to Dasboard</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- //// Send mail Modal -->

    <!--- // mail failed popup--->
    <div class="modal fade" id="project_send_failed" role="dialog">
      <div class="modal-dialog main-modal">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body modal-new-content">
            <p>
              Whoops! Something went wrong,
              <br />please try again.
            </p>
          </div>
        </div>
      </div>
    </div>
    <!--- // mail failed popup--->
  </div>
</template>
<style scoped>
span.error {
  color: #9f3a38;
  font-size: 11px;
}
</style>

<script>
import StorageFiles from "../Reusable/StorageFiles";
import VeeValidate from "vee-validate";

export default {
  components: {
    StorageFiles
  },
  props: ["settings"],
  data() {
    return {
                keywords: '',
                storage_data: '',
                order_by: 'id',
                id: this.$route.params.id,
                loading: 0,
                img_amount: '',
                medias: [],
                file: [],
                attachment_labels: [], // List of old uploaded files coming from the server
                categories: [],
                // Each file will need to be sent as FormData element
                data: new FormData(),
                percentCompleted: 0,
                imageData: '',
                image_path: '',
                storage_size: '',
                fist_name: '',
                last_name: '',
                email: '',
                address: '',
                city: '',
                state: '',
                zip: '',
                invoice_no: '',
                invoice_date: this.getdate(),
                description: '',
                amount1: '',
                description1: '',
                amount: '',
                amount_type: '',
                massage: '',
                collect_payment: 0,
                watermark_preview:"0",
                delete_after: 1,
                set_password: '',
                include_condition: 1,
                send_as: 'link',
                add_invoice_loop: 1,
                add_invoice_val: '',
                share_link:'',
                link_password:'',
                isButtonDisabled:true,
                img_360:'',
                single_storage_amount:0,
                custom_valid_msg:'',
                invoice_display:true,
                password_protect:'1',
                passwordProtect:true,
    };
  },
  watch: {
    keywords(after, before) {
      this.fetch();
    },
    order_by(after, before) {
      this.getStorageData();
    }
  },
  methods: {
    mail_mex() {
      this.flash("19MB Maximum Project Size For Send as E-mail", "error");
    },
    make_cover(id) {
      let data = {
        email: this.email,
        image_id: id
      };
      axios
        .post("/api/make_cover", data)
        .then(({ data }) => {
          this.getStorageData();
        })
        .catch(({ response }) => {
          this.getStorageData();
        });
    },
    fetch() {
      axios
        .get("/api/search_files", {
          params: {
            keywords: this.keywords,
            id: this.id
          }
        })
        .then(response => (this.medias = response.data))
        .catch(error => {});
    },
    storage_edit() {
      this.$router.push("/storage_edit/" + this.id);
    },

    getStorageData() {
      let data = {
        pro_id: this.$route.params.id,
        order_by: this.order_by
      };
      axios
        .post("/api/getstoragedata", data)
        .then(response => {
          this.medias = response.data.storage_medias;

          for (let i = 0; i < this.medias.length; i++) {
            if (this.medias[i].amount)
              this.single_storage_amount += parseFloat(this.medias[i].amount);
          }

          this.storage_data = response.data.storage_data;
          this.image_path = response.data.path;
          this.storage_size = response.data.storage_size;
        })
        .catch(({ response }) => {
          this.$router.push("/");
        });
    },
    getUserFiles() {
      let data = {
        pro_id: this.$route.params.id,
        order_by: this.order_by
      };
      axios
        .post("/api/getstoragedata", data)
        .then(response => {
          this.medias = response.data.storage_medias;
        })
        .catch(({ response }) => {
          //console.log(response);
          this.$router.push("/");
        });
    },
    validate() {
      if (!this.file.length) {
        this.flash("Please select at least one file", "warning");
        return false;
      }
      return true;
    },
    getfileize() {
      this.upload_size = 0; // Reset to beginningƒ
      this.file.map(item => {
        this.upload_size += parseInt(item.size);
      });
      this.upload_size = Number(this.upload_size.toFixed(1));
      this.$forceUpdate();
    },
    getImagePreviews() {
      for (let i = 0; i < this.file.length; i++) {
        if (/\.(jpe?g|png|gif)$/i.test(this.file[i].name)) {
          let reader = new FileReader();
          reader.addEventListener(
            "load",
            function() {
              this.$refs["image" + parseInt(i)][0].src = reader.result;
            }.bind(this),
            false
          );
          reader.readAsDataURL(this.file[i]);
        }
      }
    },
    prepareFields() {
      for (var i = this.file.length - 1; i >= 0; i--) {
        //console.log(this.file[i].category_id);
        this.data.append("file[][0]", this.file[i]);
        this.data.append("file[][1]", this.file[i].category_id);
      }
      for (var i = this.attachment_labels.length - 1; i >= 0; i--) {}
    },
    removeAttachment(attachment) {
      this.file.splice(this.file.indexOf(attachment), 1);
      this.getfileize();
      this.fileInput.file = null;
    },
    uploadFieldChange(e) {
      e.stopPropagation();
      e.preventDefault();

      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      for (var i = files.length - 1; i >= 0; i--) {
        this.file.push(files[i]);
      }
      // Reset the form to avoid copying these files multiple times into this.file
      document.getElementById("file").value = [];
      this.getImagePreviews();

      this.prepareFields();
      this.$validator.validate("Image Amount").then(res => {
        if (!res) {
          check_amount = 1;
        }
      });
      if (!this.validate()) {
        return false;
      }
      this.loading = 1;
      var config = {
        headers: {
          "Content-Type": "multipart/form-data"
        },
        onUploadProgress: function(progressEvent) {
          this.percentCompleted = Math.round(
            (progressEvent.loaded * 100) / progressEvent.total
          );
          //window.Event.fire('percent', this.percentCompleted);
          //console.log(this.percentCompleted);
          this.$forceUpdate();
        }.bind(this)
      };

      console.log(this.data);

      this.data.append("imgamount", this.img_amount);
      this.data.append("storage_id", this.$route.params.id);
      this.data.append("img_360", this.img_360);
      axios
        .post("/api/storage-multiple-files", this.data, config)
        .then(
          function(response) {
            if (response.data.success) {
              this.flash("Files uploaded!", "success");
              this.resetData();
              this.getStorageData();
              this.loading = 0;
              //window.Event.fire('reload_files'); // Tell AttachmentList component to refresh its list
            } else {
              this.loading = 0;

              this.flash("Something went wrong", "error");
            }
          }.bind(this)
        ) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
        .catch(function(error) {
          //  console.log(error);
          this.loading = 0;
        });
    },
    submit() {},
    resetData() {
      //console.log('reset data');
      this.data = new FormData(); // Reset it completely
      this.file = [];
      this.percentCompleted = 0;
    },
    start() {
      this.getStorageData();
    },

    tabs(id) {
      if (id === 1) {
        $("#tabs1").addClass("active");
        $("#tabs_show1").show();
      } else {
        $("#tabs1").removeClass("active");
        $("#tabs_show1").hide();
      }
    },
    storage_send() {
      let data = {
        id: this.storage_data.id,
        fist_name: this.fist_name,
        last_name: this.last_name,
        email: this.email,
        address: this.address,
        city: this.city,
        state: this.state,
        zip: this.zip,
        invoice_no: this.invoice_no,
        invoice_date: this.invoice_date,
        description: $(".invoice_des")
          .map(function() {
            return this.value;
          })
          .get(),
        description1: $(".invoice_des1")
          .map(function() {
            return this.value;
          })
          .get(),
        amount: $(".invoice_amount")
          .map(function() {
            return this.value;
          })
          .get(),
        amount1: $(".invoice_amount1")
          .map(function() {
            return this.value;
          })
          .get(),
        amount_type: $(".invoice_amount_type")
          .map(function() {
            return this.value;
          })
          .get(),
        amount_type1: $(".invoice_amount_type1")
          .map(function() {
            return this.value;
          })
          .get(),
        massage: this.massage,
        collect_payment: this.collect_payment,
        delete_after: this.delete_after,
        set_password: this.set_password,
        include_condition: this.include_condition,
        send_as: this.send_as,
        password_protect: this.password_protect,
        watermark_preview: this.watermark_preview
      };
      axios
        .post("/api/Storage_Send_By_Mail", data)
        .then(response => {
          console.log(response);
          if (this.send_as == "link") {
            this.link_password = this.set_password;
            this.share_link = decodeURIComponent(response.data.share_link);
            $("#shareLinkModal").modal("show");
          } else {
            $("#sendMailModal").modal("show");
          }
          // this.$swal({
          //     title: "Mail Send Successfully!",
          //     text: 'Please Check Mail Your Inbox.',
          //     type: 'success',
          // });
        })
        .catch(response => {
          // this.$swal({
          //     type: 'error',
          //     title: 'Oops...',
          //     text: 'Something went wrong!',
          // });
          $("#project_send_failed").modal();
        });
    },
    closeSuccessPopup() {
      $("#shareLinkModal").modal("toggle");
      this.$router.push("/dashboard");
    },
    copyLinkData() {
      var copyGfGText = document.getElementById("share_link_copy");
      copyGfGText.select();
      document.execCommand("copy");
    },
    returnDashboard() {
      $("#sendMailModal").modal("toggle");
      this.$router.push("/dashboard");
    },
    getdate() {
      var myDate = new Date();
      var month = ("0" + (myDate.getMonth() + 1)).slice(-2);
      var date = ("0" + myDate.getDate()).slice(-2);
      var year = myDate.getFullYear();
      var formattedDate = year + "/" + month + "/" + date;
      return formattedDate;
    },
    handleDragOver(evt) {
      // alert();
      evt.stopPropagation();
      evt.preventDefault();
      evt.dataTransfer.dropEffect = "copy"; // Explicitly show this is a copy.
    }
  },
  created() {
    this.start();
    VeeValidate.Validator.extend("required", {
      getMessage: field => field + " is required",
      validate: (input, args) => {
        if (input.length > 0) {
          return true;
        } else {
          return false;
        }
      }
    });
  },
  mounted() {
    var dropZone = document.getElementById("fileDrag");
    console.log(dropZone);
    dropZone.addEventListener("dragover", this.handleDragOver, false);
    dropZone.addEventListener("drop", this.uploadFieldChange, false);
  }
};
</script>