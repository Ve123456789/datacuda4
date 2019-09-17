<template>
    <div>
        <div v-if="loading" class="main_model_box">
            <div class="model_box loader">
                <!--<img :src="'/assets/img/loader.gif'" >-->
                <!--&lt;!&ndash;<progress max="100" :value.prop="percentCompleted"> </progress>&ndash;&gt;-->
                <!--{{ percentCompleted }} %-->
            </div>
        </div>
        <section class="margin_top_for_header"></section>
        <!-- Dashboard Project -->
        <section class="dashboard__filter filterSec">
            <div class="d_container container">

                <div class="file-upload">
                    <div class="form-group btnSec">
                        <div class="row">
                            <!-- <div class="col-md-4 col-lg-3 my-5x">
                                <ul class="filter_list_nav">
                                    <li>
                                        <div class="form-group">
                                            <select name="" id="" class="form-control" v-model="order_by">
                                                <option value="id">Sort</option>
                                                <option value="project_name">Name</option>
                                                <option value="created_at">Date</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div> -->
                            <div class="col-md-8 col-lg-3 my-5x header-plans">
                                <p><i class="fa fa-cloud-upload" aria-hidden="true"></i> Project Size :
                                    {{project_size.value}}{{project_size.type}} </p>
                            </div>
                            <!-- <div class="col-md-12 col-lg-6 my-5x">
                                <div class="row">
                                    <div class="col-md-6 my-5x offset-md-6">
                                        <form class="search__container">
                                            <input type="text" id="search-bar" v-model="keywords">
                                            <a href="#" class="p_search_icon"><img
                                                    src="../../../img/search_icon.png"></a>
                                        </form>
                                    </div> -->

                                    <!-- <div class="col-md-6 headerBtn my-5x">
                                        <div class="uploadSection headerBtn">
                                            <a href="#" class="blue_btn" @click="submit"> <i class="fa fa-cloud-upload"
                                                    aria-hidden="true"></i>Upload to storage</a>
                                        </div>
                                    </div> -->
                                <!-- </div>

                            </div> -->

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
                                <span v-if="medias[0]"><img v-bind:src="image_path+'medium/'+ medias[0].filename"
                                        v-img:name class="project_profile_img" width="100%"></span>
                                <span v-else><img v-bind:src="'storage/user_medium/'" v-img:name
                                        class="project_profile_img" width="100%"></span>
                                <div class="project_content_wrapper">
                                    <div class="clearfix">
                                        <div class="p_left_content">
                                            <h3>{{ project_data.project_name }}</h3>
                                            <p>{{ project_data.project_date }}</p>
                                        </div>

                                        <div class="p_right_content" id="project_edit_btn">
                                            <a href="javascript:void(0)" v-on:click="project_edit()"><img
                                                    src="../../../img/edit.svg" class="edit_icon"></a>
                                            <p>Preview</p>
                                        </div>
                                    </div>
                                </div>
                                <nav>
                                    <ul class="project_profile_nav">
                                        <li><a href="javascript:void(0)" id="tabs1" class="active" v-on:click="tabs(1)">
                                                <div class="img__icon"><img src="../../../img/upload.png"></div>
                                                <span>Upload files</span>
                                            </a></li>
                                        <li><a href="javascript:void(0)" id="tabs2" v-on:click="tabs(2)">
                                                <div class="img__icon"><img src="../../../img/avatar_icon.png"> </div>
                                                <span>Client information</span>
                                            </a></li>
                                        <li><a href="javascript:void(0)" id="tabs3" v-on:click="tabs(3)">
                                                <div class="img__icon"><img src="../../../img/invoice.png"> </div>
                                                <span>Invoice details</span>
                                            </a></li>
                                        <li><a href="javascript:void(0)" id="tabs4" v-on:click="tabs(4)">
                                                <div class="img__icon"><img
                                                        src="../../../img/circular-plus-button-black.png"> </div>
                                                <span>Additional items</span>
                                            </a></li>
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
                                                        <ProjectFiles v-for="media in medias" :media="media" :key="media.id"></ProjectFiles>
                                                        <div class="col-md-6 detailList"  v-for="(attachment, index) in file">
                                                            <div class="thumbnail thumbnailSecNotUploaded">

                                                                <div class="imgThumb">
                                                                    <img v-bind:ref="'image'+parseInt( index )" class="img-rounded" width="100%">
                                                                </div>
                                                                <div class="caption">
                                                                    <p class="proName">
                                                                        <!--<span class="proDate">12/08/2017</span>-->
                                                                        {{ attachment.name.substring(0,10) + '...' }}
                                                                    </p>
                                                                    <p class="listBott">
                                                                        <span class="fileSize">{{ Number((attachment.size / 1024 / 1024).toFixed(1)) }}  <span>mb</span> </span>
                                                                        <span class="fileRename"><i class="fa fa-trash-o" aria-hidden="true" @click="removeAttachment(attachment)"></i></span>
                                                                    </p>
                                                                    <!--<p class="payment"><span class="amt">$ <input type="number" :id="'image_amount_e'+media.id" :value="media.amount" readonly="readonly" v-on:focusout="amout_edit(media.id,media.amount)"></span></p>-->
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="force-overflow">

                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-4 dragSec " id="fileDrag" >
                                                    <div class="sec sec-select "   >
                                                        <img src="/assets/img/upload.svg" class="uploa_d_icon">
                                                        <h3>Drag & Drop</h3>
                                                        <span> your file here or <label class="btn_browse" for="file">
                                                                Browse Files</label></span>
                                                        <input type="file" id="file" multiple="multiple"
                                                            @change="uploadFieldChange">
                                                        <div class="threesixty-wrapper">
                                                           <div class=""><input type="checkbox" v-model="img_360" value="1" ></div>
                                                           <div class=""><p>360 Degree Image </p></div>
                                                        </div> 
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none" id="tabs_show2">
                            <div class="additional__iteam">
                                <form class="additional_form">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="client-info-heading col-md-12 mb-3">
                                                    <span></span>
                                                    <p class="mb-0">Client information</p>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" name="First Name" placeholder="First Name"
                                                        class="form-control" v-model="fist_name"
                                                        v-validate="'required'">
                                                    <span class="error"
                                                        v-if="errors.has('First Name')">{{errors.first('First Name')}}</span>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" name="Last Name" placeholder="Last Name"
                                                        class="form-control" v-model="last_name"
                                                        v-validate="'required'">
                                                    <span class="error"
                                                        v-if="errors.has('Last Name')">{{errors.first('Last Name')}}</span>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <input type="text" name="Email" placeholder="Email"
                                                        class="form-control" v-model="email"
                                                        v-validate="'required|email'">
                                                    <span class="error"
                                                        v-if="errors.has('Email')">{{errors.first('Email')}}</span>
                                                </div>

                                                <div class="client-info-heading col-md-12 mb-3 mt-5">
                                                    <span></span>
                                                    <p class="mb-0">Client Address</p>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <input type="text" name="Address" placeholder="Address"
                                                        class="form-control" v-model="address" v-validate="">
                                                    <span class="error"
                                                        v-if="errors.has('Address')">{{errors.first('Address')}}</span>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" name="City" placeholder="City"
                                                        class="form-control" v-model="city" v-validate="">
                                                    <span class="error"
                                                        v-if="errors.has('City')">{{errors.first('City')}}</span>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" name="State" placeholder="State"
                                                        class="form-control" v-model="state" v-validate="">
                                                    <span class="error"
                                                        v-if="errors.has('State')">{{errors.first('State')}}</span>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" name="Zip" placeholder="Zip" class="form-control"
                                                        v-model="zip" v-validate="">
                                                    <span class="error"
                                                        v-if="errors.has('Zip')">{{errors.first('Zip')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <ul class="form_btn_list">
                                        <li><a href="javascript:void(0)" class="client-info-back">Back</a> <a
                                                href="javascript:void(0)" v-on:click="valid_tabs(3)">Next</a></li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                        <div style="display: none" id="tabs_show3">
                            <div class="additional__iteam">
                                <form class="additional_form">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                 <div class="client-info-heading col-md-12 mb-3">
                                                    <span></span>
                                                    <p class="mb-0">Need to Collect Payment?</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="buttons__form_group">

                                                        <div class="form-group">

                                                            <div class="yes_no_btn">
                                                                <div class="inputGroup">
                                                                    <input id="option1" name="option1" type="radio"
                                                                        value="0" v-model="collect_payment" v-on:click="setPayment" />
                                                                    <label for="option1">Yes</label>
                                                                </div>
                                                                <div class="inputGroup">
                                                                    <input id="option2" name="option1" type="radio"
                                                                        value="1" v-model="collect_payment" v-on:click="setPayment" />
                                                                    <label for="option2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group text__area pt-0">
                                                <textarea placeholder="Enter your message" class="form-control"
                                                    cols="30" rows="5" name="Message" v-model="massage"
                                                    v-validate="''"></textarea>
                                                <span>0/400 Characters</span>
                                                </div>
                                                </div>
                                                <div class="client-info-heading col-md-12 mb-3" v-if="invoice_display" >
                                                    <span></span>
                                                    <p class="mb-0">Invoice information</p>
                                                </div>
                                                <div class="form-group col-md-6" v-if="invoice_display" >
                                                    <input type="text" name="Invoice No" placeholder="Invoice no."
                                                        class="form-control" v-model="invoice_no"
                                                        v-validate="'required'" >
                                                        
                                                    <span class="error"
                                                        v-if="errors.has('Invoice No')">{{errors.first('Invoice No')}}</span>
                                                </div>
                                                <div class="form-group col-md-6 col-lg-6 col-sm-12" v-if="invoice_display" >
                                                    <span class="error"
                                                v-if="errors.has('Message')">{{errors.first('Message')}}</span>
                                                    <input id="datefield" placeholder="Invoice Date" type="date" name="Invoice Date" class=" form-control"
                                                        v-model="invoice_date" v-validate="'required'">
                                                    <span class="error"
                                                        v-if="errors.has('Invoice Date')">{{errors.first('Invoice Date')}}</span>
                                            </div>
                                            
                                                
                                                <div class="client-info-heading col-md-12 mb-3" v-if="invoice_display" >
                                                    <span></span>
                                                    <p class="mb-0">Invoice item</p>
                                                </div>
                                                <div class="form-group col-md-6" v-if="invoice_display" >
                                                    <input type="text" name="Description" placeholder="Description"
                                                        class="form-control invoice_des1 font-weight-bold no-border" value="Project Amount" 
                                                        v-validate="'required'">
                                                    <span class="error"
                                                        v-if="errors.has('Description')">{{errors.first('Description')}}</span>
                                                </div>
                                                <div class="form-group col-md-3" v-if="invoice_display" >
                                                    <input type="number" name="Amount" placeholder=""
                                                        class="form-control invoice_amount1" v-validate="'required'">
                                                        <span class="error" > {{ custom_valid_msg }} </span>
                                                    <span class="error" v-if="errors.has('Amount')">{{errors.first('Amount')}}</span>
                                                </div>
                                                <div class="form-group col-md-3" v-if="invoice_display" >

                                                    <select name="AmountType" class="form-control invoice_amount_type1"
                                                        v-validate="'required'">
                                                        <option value="USD" selected>USD</option>
                                                    </select>
                                                    <span class="error"
                                                        v-if="errors.has('Amount Type')">{{errors.first('Amount Type')}}</span>
                                                </div>

                                                <div class="col-md-12" >

                                                    <div v-for="(desc,k) in description1" :key="k" >                                                        
                                                        <div class="row invoice_r_form">
                                                            <div class="col-md-6 col-sm-6 invoice_r_form_1 form-group">
                                                                <input type="text"
                                                                    :name="'Description '+ k"
                                                                    placeholder="Description"
                                                                    class="form-control invoice_des"
                                                                    v-validate="'required'" :value='desc' >
                                                                <span class="error"
                                                                    v-if="errors.has('Description '+k)">{{errors.first('Description '+k)}}</span>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 input_type_date form-group">
                                                                <input type="number" :name="'Amount '+ k"
                                                                    placeholder="320.00"
                                                                    class="form-control invoice_amount"
                                                                    v-validate="'required'" :value='amount1[k]' >
                                                                <span class="error"
                                                                    v-if="errors.has('Amount '+k)">{{errors.first('Amount '+k)}}
                                                                    
                                                                </span>
                                                                
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 input_type_currency">
                                                                <select :name="'Amount Type '+ k"
                                                                    class="form-control invoice_amount_type"
                                                                    v-validate="'required'">
                                                                    <option value="USD" selected>USD</option>
                                                                </select>
                                                                
                                                                <span class="error"
                                                                    v-if="errors.has('Amount Type '+k)">{{errors.first('Amount Type '+k)}}</span>
                                                            </div>
                                                            <!-- <div class="col-md-1 col-sm-1 input_type_currency form-group"
                                                                v-if="description1.length == k">
                                                                <span class="btn btn-danger btn-sm" style="height: auto"
                                                                    v-on:click="remove_add_invoice()"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></span>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                    
                                                    <div v-for="add_invoice_val in add_invoice_loop" v-if="add_invoice_val !== 1">                                                        
                                                        <div class="row invoice_r_form">
                                                            <div class="col-md-5 col-sm-5 invoice_r_form_1 form-group">
                                                                <input type="text"
                                                                    :name="'Description '+ add_invoice_val"
                                                                    placeholder="Description"
                                                                    class="form-control invoice_des"
                                                                    v-validate="'required'">
                                                                <span class="error"
                                                                    v-if="errors.has('Description '+add_invoice_val)">{{errors.first('Description '+add_invoice_val)}}</span>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 input_type_date form-group">
                                                                <input type="number" :name="'Amount '+ add_invoice_val"
                                                                    placeholder="320.00"
                                                                    class="form-control invoice_amount"
                                                                    v-validate="'required'">
                                                                <span class="error"
                                                                    v-if="errors.has('Amount '+add_invoice_val)">{{errors.first('Amount '+add_invoice_val)}}
                                                                    
                                                                </span>
                                                                
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 input_type_currency">
                                                                <select :name="'Amount Type '+ add_invoice_val"
                                                                    class="form-control invoice_amount_type"
                                                                    v-validate="'required'">
                                                                    <option value="USD" selected>USD</option>
                                                                </select>
                                                                <span class="error"
                                                                    v-if="errors.has('Amount Type '+add_invoice_val)">{{errors.first('Amount Type '+add_invoice_val)}}</span>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 input_type_currency form-group"
                                                                v-if="add_invoice_val === add_invoice_loop">
                                                                <span class="btn btn-danger btn-sm" style="height: auto"
                                                                    v-on:click="remove_add_invoice()"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                     
                                                   
                                                </div>



                                                <div class="form-group col-md-12 mt-2" v-if="invoice_display" >
                                                    <div class="add_line_iteam" v-on:click="add_invoice()">
                                                        <img src="../../../img/add_line_iteam.png" alt=""> <span>Add
                                                            line item</span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-3 "
                                                    v-if="add_invoice_val === add_invoice_loop && add_invoice_val !== 1 && invoice_display" >
                                                    <span class="btn btn-danger btn-sm" style="height: auto"
                                                        v-on:click="remove_add_invoice()"><i class="fa fa-times"
                                                            aria-hidden="true"></i></span>
                                                </div>





                                               
                                                <ul class="form_btn_list">
                                                    <li><a href="javascript:void(0)" v-on:click="tabs(2)"
                                                            class="client-info-back">Back</a></li>
                                                    <li><a href="javascript:void(0)" v-on:click="valid_tabs(4)">Next</a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                        <div style="display: none" id="tabs_show4">
                            <div class="additional__iteam">
                                <form class="additional_form">
                                  <div class="row">
                                      <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="client-info-heading col-md-12 mb-3">
                                                        <span></span>
                                                        <p class="mb-0  bg-green">Password protect</p>
                                                    </div>
                                                <div class="buttons__form_group">
                                                    <div class="form-group">
                                                        <div class="yes_no_btn">
                                                            <div class="inputGroup">
                                                                <input id="option66" name="option6" type="radio" value="1"
                                                                    v-model="password_protect" v-on:change="passwordProtectClick" checked />
                                                                <label for="option66">Yes</label>
                                                            </div>
                                                            <div class="inputGroup">
                                                                <input id="option67" name="option6" type="radio" value="0"
                                                                    v-model="password_protect"  v-on:change="passwordProtectClick" />
                                                                <label for="option67">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="client-info-heading col-md-12 mb-3" style="background:#88d317">
                                                        <span></span>
                                                        <p class="mb-0  bg-green">Delete after</p>
                                                    </div>
                                                    <div class="form-group col-md-12 ">
                                                        <select name="" class="form-control" v-model="delete_after">
                                                            <option v-for="val in 12" :value="val">{{val}} month</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="client-info-heading1 col-md-12 mb-3" style="background:#88d317">
                                                        <span></span>
                                                        <p class="mb-0">Set password</p>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <input type="password" class="form-control" placeholder="Password"
                                                            v-model="set_password" autocomplete="off" required  v-if="passwordProtect" >
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                  </div>
                                    

                                    <div class="buttons__form_group">
                                        <div class="form-group ckeck_box col-md-6 offset-md-3">
                                            <span class="label__text">Include film/images release</span>
                                            <input type="checkbox" id="switch" v-model="include_condition" /><label
                                                for="switch">Toggle</label>
                                        </div>
                                    </div>

                                    <div class="client-info-heading col-md-6 mb-3 bg-green">
                                        <span></span>
                                        <p class="mb-0">Watermark files for previewing?</p>
                                    </div>
                                    <div class="buttons__form_group">
                                        <div class="form-group col-md-6 offset-md-3">
                                            <div class="yes_no_btn">
                                                <div class="inputGroup">
                                                    <input id="option3" name="option5" type="radio" value="0"
                                                        v-model="watermark_preview" />
                                                    <label for="option3">Yes</label>
                                                </div>
                                                <div class="inputGroup">
                                                    <input id="option4" name="option5" type="radio" value="1"
                                                        v-model="watermark_preview" v-bind:disabled="isButtonDisabled" />
                                                    <label for="option4">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons__form_group" style="display:none;">
                                        <div class="form-group ckeck_box">
                                            <span class="label__text">Project According Amount</span>
                                            <input type="checkbox" id="accordingamount"
                                                v-on:change="ChangeProjectAccording()" /><label
                                                for="accordingamount">Toggle</label>
                                            <span style="margin-left:40px"></span><span class="label__text">Image
                                                According Amount</span>
                                            <input type="text" id="projectamount" :value="project_data.project_price"
                                                class="form-control" v-on:focusout="ChangeProjectAccordingAmount()">
                                        </div>
                                    </div>
                                    
                                    <div class="buttons__form_group">
                                        <div class="form-group col-md-6 offset-md-3">
                                            <span class="radio_btn_label">Send as: </span>
                                            <div class="radio_btn" v-on:click="mail_mex()"
                                                v-if="project_size.mail_size === 0">
                                                <span>E-mail</span>
                                                <input type="radio" disabled>
                                                <label for="test1"></label>
                                            </div>
                                            <div class="radio_btn" v-else>
                                                <span>E-mail</span>
                                                <input type="radio" id="test1" name="radio-group" value="email"
                                                    v-model="send_as">
                                                <label for="test1"></label>
                                            </div>
                                            <div class="radio_btn">
                                                <span>Link</span>
                                                <input type="radio" id="test2" name="radio-group" value="link"
                                                    v-model="send_as">
                                                <label for="test2"></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <ul class="form_btn_list">
                                        <li><a href="javascript:void(0)" v-on:click="tabs(3)"
                                                class="client-info-back">Preview</a></li>
                                        <li><a href="javascript:void(0)" v-on:click="project_send()">Send</a></li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



   <!-- Share link Modal -->
    <div class="modal fade project-modal" id="shareLinkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-body" >
                    <div class="row p-0 m-0">
                        <div class="left-wrapper m-0" style="background:url(./assets/img/payment_bg.png) center; background-repeat: no-repeat; background-size: cover;">
                            <div class="left-content" >
                                <img  class="img-responsive" src="../../../img/rocket.svg" alt="">
                                <h2>You're done file sent successful!</h2>
                            </div>
                        </div>
                        <div class="right-wrapper">
                            <button type="button" class="close mr-2" v-on:click="closeSuccessPopup" >&times;</button>
                            <div class="right-content">
                                <h4 class="mb-4">
                                    Copy your download link
                                </h4>
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" placeholder="link" :value="share_link" id="share_link_copy" >
                                </div>
                                <button type="button" class="btn mt-3 green_btn" v-on:click="copyLinkData" >
                                    <span aria-hidden="true">Copy Link</span>
                                </button>
                                <!-- <div class="mt-3 pass">
                                    <p><span class="pr-2 ">Password</span> {{ link_password }}</p> 
                                </div> -->
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //// Share link Modal -->

    <!-- Send mail Modal -->
    <div class="modal fade project-modal" id="sendMailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body" >
                    <div class="row p-0 m-0">
                        <div class="left-wrapper m-0"  style="background:url(./assets/img/payment_bg.png) center; background-repeat: no-repeat; background-size: cover;">
                            <div class="left-content" >
                                <img  class="img-responsive" src="../../../img/rocket.svg" alt="">
                                <h2>You're done file sent successful!</h2>
                            </div>
                        </div>
                        <div class="right-wrapper">
                            <div class="right-content">
                                <h4 class="mb-4">
                                    You can monitor when your files are viewed and payment recieved on your dashboard
                                </h4>
                                <button type="button" class="btn mt-3 green_btn"  v-on:click="returnDashboard()" >
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
          <p>Whoops! Something went wrong,<br/> please try again.</p>
        </div>
        
      </div>
      
    </div>
  </div>
  <!--- // mail failed popup--->

    </div>
</template>
<style scoped>
    span.error {
        color: #9F3A38;
        font-size: 11px;
    }
</style>

<script>
   
    import ProjectFiles from '../Reusable/ProjectFiles';
    import VeeValidate from 'vee-validate';

    export default {
        components: {
            ProjectFiles,
        },
        props: [
            'settings'
        ],
        data() {
            return {
                keywords: '',
                project_data: '',
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
                project_size: '',
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
                single_project_amount:0,
                custom_valid_msg:'',
                invoice_display:true,
                password_protect:'1',
                passwordProtect:true,
            }
        },
        watch: {
            keywords(after, before) {
                this.fetch();
            },
            order_by(after, before) {
                this.getProjectData();
            }
        },
        methods: {
            passwordProtectClick(){

                //console.log("pass click",this.password_protect );

               if(this.password_protect == 1){
                   this.passwordProtect = true;
               }else{
                   this.passwordProtect = false;
               }
            },
            mail_mex() {
                this.flash('19MB Maximum Project Size For Send as E-mail', 'error');
            },
            add_invoice() {
                this.add_invoice_loop = this.add_invoice_loop + 1;
            },
            remove_add_invoice() {
                this.add_invoice_loop = this.add_invoice_loop - 1;
            },
            make_cover(id) {
                let data = {
                    email: this.email,
                    image_id: id
                };
                axios.post('/api/make_cover', data)
                    .then(({
                        data
                    }) => {
                        this.getProjectData();
                    })
                    .catch(({
                        response
                    }) => {
                        this.getProjectData();
                    });
            },
            fetch() {
                axios.get('/api/search_files', {
                        params: {
                            keywords: this.keywords,
                            id: this.id
                        }
                    })
                    .then(response => this.medias = response.data)
                    .catch(error => {});
            },
            project_edit() {
                this.$router.push('/project_edit/' + this.id);
            },

            setPayment(){
                //console.log(this.collect_payment);
                if(this.collect_payment=='1'){
                    this.invoice_display = true;
                }else{
                    this.invoice_display = false;
                }
            },
            getProjectData() {
                let data = {
                    pro_id: this.$route.params.id,
                    order_by: this.order_by
                };
                axios.post('/api/getprojectdata', data).then((response) => {
                       
                        this.medias = response.data.project_medias;
                        
                        for(let i = 0; i < this.medias.length; i++){
                            if(this.medias[i].amount)
                            this.single_project_amount += parseFloat(this.medias[i].amount);
                        }
                        
                        

                        this.project_data = response.data.project_data;
                        this.image_path = response.data.path;
                        this.project_size = response.data.project_size;

                        let project_last_share = response.data.project_last_share;
                        if(project_last_share){
                            this.fist_name=project_last_share.fist_name;
                            this.last_name=project_last_share.last_name;
                            this.email=project_last_share.email;
                            this.address=project_last_share.address;
                            this.city=project_last_share.city;
                            this.state=project_last_share.state;
                            this.zip=project_last_share.zip;
                            this.invoice_no=project_last_share.invoice_no;
                            this.invoice_date=project_last_share.invoice_date;
                            this.description1=JSON.parse(project_last_share.description);
                            this.amount1=JSON.parse(project_last_share.amount);
   
                            $('.invoice_amount1').val(project_last_share.buy_amount);
                            //this.amount_type='',
                            this.massage=project_last_share.massage;
                            //this.collect_payment=0,
                            //this.watermark_preview=project_last_share,
                            this.delete_after=project_last_share.delete_after;
                            //this.set_password='',
                            this.include_condition=project_last_share.include_condition;
                            this.send_as=project_last_share.send_as;
                        }
                        

                    })
                    .catch(({
                        response
                    }) => {
                        this.$router.push('/');
                    });
            },
            getUserFiles() {
                let data = {
                    pro_id: this.$route.params.id,
                    order_by: this.order_by
                };
                axios.post('/api/getprojectdata', data).then((response) => {
                        this.medias = response.data.project_medias;

                    })
                    .catch(({
                        response
                    }) => {
                        //console.log(response);
                        this.$router.push('/');
                    });
            },
            selectCategory(attachment, category_id) {
                attachment.category_id = category_id;
                // console.log(attachment);
                this.$forceUpdate();
            },
            validate() {
                if (!this.file.length) {
                    this.flash('Please select at least one file', "warning");
                    return false;
                }
                return true;
            },
            getfileize() {
                this.upload_size = 0; // Reset to beginningƒ
                this.file.map((item) => {
                    this.upload_size += parseInt(item.size);
                });
                this.upload_size = Number((this.upload_size).toFixed(1));
                this.$forceUpdate();
            },
            getImagePreviews() {
                for (let i = 0; i < this.file.length; i++) {
                    if (/\.(jpe?g|png|gif)$/i.test(this.file[i].name)) {
                        let reader = new FileReader();
                        reader.addEventListener("load", function () {
                            this.$refs['image' + parseInt(i)][0].src = reader.result;
                        }.bind(this), false);
                        reader.readAsDataURL(this.file[i])
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
                this.fileInput.file = null

            },
            uploadFieldChange(e) {
                e.stopPropagation();
                e.preventDefault();

                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.file.push(files[i]);
                }
                // Reset the form to avoid copying these files multiple times into this.file
                document.getElementById("file").value = [];
                this.getImagePreviews();
      
            
                this.prepareFields();
                this.$validator.validate('Image Amount').then((res) => {
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
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function (progressEvent) {
                        this.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                        //window.Event.fire('percent', this.percentCompleted);
                        //console.log(this.percentCompleted);
                        this.$forceUpdate();
                    }.bind(this)
                };

                console.log(this.data);

                this.data.append('imgamount', this.img_amount);
                this.data.append('project_id', this.$route.params.id);
                this.data.append('img_360',this.img_360);
                axios.post('/api/project-multiple-files', this.data, config)
                    .then(function (response) {

                        if (response.data.success) {
                            this.flash('Files uploaded!', 'success');
                            this.resetData();
                            this.getProjectData();
                            this.loading = 0;
                            //window.Event.fire('reload_files'); // Tell AttachmentList component to refresh its list
                        } else {
                            this.loading = 0;

                            this.flash('Something went wrong', 'error');
                        }
                    }.bind(
                        this
                    )) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
                    .catch(function (error) {
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
                this.getProjectData();

            },
            valid_tabs(id) {
                if (id === 3) {
                    this.$validator.validate('First Name');
                    this.$validator.validate('Last Name');
                    this.$validator.validate('Email');
                    this.$validator.validate('Address');
                    this.$validator.validate('City');
                    this.$validator.validate('State');
                    this.$validator.validate('Zip')
                        .then(() => {
                            if (this.errors.any()) {
                                return;
                            } else {
                                if (!this.errors.any()) {
                                    this.tabs(id)
                                }
                            }
                        });
                }
                if (id === 4) {
                    
                    //this.$validator.validate('Amount Type');
                    

                    if(this.collect_payment == '0'){
                        this.isButtonDisabled = true;
                    }else{
                        this.isButtonDisabled = false;
                    }

                    
                    console.log(this.collect_payment);

                    if(this.collect_payment == '0'){

                        this.$validator.validate('Invoice No');
                        this.$validator.validate('Invoice Date');
                        this.$validator.validate('Description');
                        this.$validator.validate('Amount');

                        var i = '';
                        for (i = 2; i <= this.add_invoice_loop; i++) {
                            //console.log(i);
                            this.$validator.validate('Description ' + i);
                            this.$validator.validate('Amount ' + i);
                            //this.$validator.validate('Amount Type ' + i);
                        }

                        let cust_valid = false;

                        const reducer = (accumulator, currentValue) => parseFloat(accumulator) + parseFloat(currentValue);
                        const amount_data = $('.invoice_amount').map(function () {
                            return this.value;
                        }).get()
                        let user_amount;
                        if(amount_data.length>0){
                            user_amount = amount_data.reduce(reducer);
                        }else{
                            user_amount = 0;
                        }
                        const user_amount1 = $('.invoice_amount1').map(function () {
                            return this.value;
                        }).get().reduce(reducer);
                    
                        // if(user_amount && user_amount>0){
                        //     cust_valid = false;
                        // }else{
                        //     cust_valid = true;
                        // }
                        
                        if(user_amount > 0 && user_amount1 != user_amount){
                            cust_valid = false;
                            this.custom_valid_msg = "Total amount should be equal to project amount $"+user_amount1;
                            
                        }else{
                            cust_valid = true;
                            this.custom_valid_msg = "";
                            
                        }

                        this.$validator.validate('Message')
                        .then(() => {
                            if (this.errors.any() || !cust_valid) {
                                return;
                            } else {
                                if (!this.errors.any()) {
                                    this.tabs(id)
                                }
                            }
                        });

                    }else{
                        this.tabs(id)
                    }

                    
                }
            },
            tabs(id) {
                if (id === 1) {
                    $('#tabs1').addClass('active');
                    $('#tabs_show1').show();
                } else {
                    $('#tabs1').removeClass('active');
                    $('#tabs_show1').hide();
                }
                if (id === 2) {
                    $('#tabs2').addClass('active');
                    $(newFunction()).show();
                } else {
                    $('#tabs2').removeClass('active');
                    $('#tabs_show2').hide();
                }
                if (id === 3) {
                    $('#tabs3').addClass('active');
                    $('#tabs_show3').show();
                } else {
                    $('#tabs3').removeClass('active');
                    $('#tabs_show3').hide();
                }
                if (id === 4) {
                    $('#tabs4').addClass('active');
                    $('#tabs_show4').show();
                } else {
                    $('#tabs4').removeClass('active');
                    $('#tabs_show4').hide();
                }
            },
            ChangeProjectAccording() {
                let check_val = '';

                if ($('#accordingamount').is(':checked')) {
                    $('#projectamount').hide();
                    $('#project_edit_btn').show();
                    check_val = 1;
                } else {
                    $('#projectamount').show();
                    $('#project_edit_btn').hide();
                    check_val = 0;
                }
                let data = {
                    id: this.project_data.id,
                    project_according: check_val,
                    /*amount: projecta_amount,*/
                };
                axios
                    .post('/api/Change_Project_According_Type', data)
                    .then((response) => {
                        //  console.log(response);
                    })
                    .catch((response) => {
                        //  console.log(response);
                    });
            },
            ChangeProjectAccordingAmount() {
                let projecta_amount = '';
                projecta_amount = $('#projectamount').val();
                let data = {
                    id: this.project_data.id,
                    amount: projecta_amount,
                };
                axios
                    .post('/api/Change_Project_According_Amount', data)
                    .then((response) => {
                        // console.log(response);
                    })
                    .catch((response) => {
                        // console.log(response);
                    });
            },
            ExecuteProjectAccording() {
                if (this.project_data.project_according === 1) {
                    $('#accordingamount').prop("checked", true);
                    $('#projectamount').hide();
                    $('#project_edit_btn').show();
                }   
                if (this.project_data.project_according === 0) {
                    $('#accordingamount').prop("checked", false);
                    $('#projectamount').show();
                    $('#project_edit_btn').hide();
                }
            },
            project_send() {
                let data = {
                    id: this.project_data.id,
                    fist_name: this.fist_name,
                    last_name: this.last_name,
                    email: this.email,
                    address: this.address,
                    city: this.city,
                    state: this.state,
                    zip: this.zip,
                    invoice_no: this.invoice_no,
                    invoice_date: this.invoice_date,
                    description: $('.invoice_des').map(function () {
                        return this.value;
                    }).get(),
                    description1: $('.invoice_des1').map(function () {
                        return this.value;
                    }).get(),
                    amount: $('.invoice_amount').map(function () {
                        return this.value;
                    }).get(),
                    amount1: $('.invoice_amount1').map(function () {
                        return this.value;
                    }).get(),
                    amount_type: $('.invoice_amount_type').map(function () {
                        return this.value;
                    }).get(),
                    amount_type1: $('.invoice_amount_type1').map(function () {
                        return this.value;
                    }).get(),
                    massage: this.massage,
                    collect_payment: this.collect_payment,
                    delete_after: this.delete_after,
                    set_password: this.set_password,
                    include_condition: this.include_condition,
                    send_as: this.send_as,
                    password_protect : this.password_protect,
                    watermark_preview : this.watermark_preview,
                };
                axios
                    .post('/api/Project_Send_By_Mail', data)
                    .then((response) => {
                        console.log(response);
                        if(this.send_as == 'link' ){
                            this.link_password = this.set_password;
                            this.share_link = decodeURIComponent(response.data.share_link);
                            $('#shareLinkModal').modal('show');
                        }else{
                            $('#sendMailModal').modal('show');
                        }
                        // this.$swal({
                        //     title: "Mail Send Successfully!",
                        //     text: 'Please Check Mail Your Inbox.',
                        //     type: 'success',
                        // });
                    })
                    .catch((response) => {
                        // this.$swal({
                        //     type: 'error',
                        //     title: 'Oops...',
                        //     text: 'Something went wrong!',
                        // });
                        $("#project_send_failed").modal();
                    });
            },
            closeSuccessPopup(){
                $('#shareLinkModal').modal('toggle');
                this.$router.push('/dashboard');
            },
            copyLinkData(){
                var copyGfGText = document.getElementById("share_link_copy"); 
                copyGfGText.select(); 
                document.execCommand("copy");
            },
            returnDashboard(){
                $('#sendMailModal').modal('toggle');
                this.$router.push('/dashboard');
            },
            getdate() {
                var myDate = new Date();
                var month = ('0' + (myDate.getMonth() + 1)).slice(-2);
                var date = ('0' + myDate.getDate()).slice(-2);
                var year = myDate.getFullYear();
                var formattedDate = year + '/' + month + '/' + date;
                return formattedDate;
            },
            handleDragOver(evt) {
               // alert();
                evt.stopPropagation();
                evt.preventDefault();
                evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
            }

        },
        created() {
            this.start();
             VeeValidate.Validator.extend("required", {
                getMessage: (field) => field + " is required",
                validate: (input, args) => {
                    if(input.length > 0){
                        return true;
                    }else{
                        return false;
                    }
                }
            });
            
        },
        mounted(){
            var dropZone = document.getElementById('fileDrag');
            console.log(dropZone);
            dropZone.addEventListener('dragover',this.handleDragOver, false);
            dropZone.addEventListener('drop',this.uploadFieldChange, false);
        },
        updated() {
            this.ExecuteProjectAccording();
        }

    }

    function newFunction() {
        return '#tabs_show2';
    }
</script>