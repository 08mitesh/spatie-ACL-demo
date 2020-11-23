<template>
    <div class="p-0">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Users
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item mr-1">
                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#createUser"><i class="fas fa-plus-circle"></i> Add New</button>
                        </li>
                        <li class="nav-item">
                            <div class="input-group mt-0 input-group-sm" style="width: 350px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search by name, email">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Action</th>
                        <th>Date Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td> {{ user.name }}</td>
                            <td >
                                <!-- <div v-for="role in user.roles" :key="role.id"> -->
                                    <b-button v-for="role in user.roles" :key="role.id" variant="info" size="sm">{{role.name}}</b-button>
                                <!-- </div> -->
                            </td>
                            <td>{{ user.email }}</td>
                            <td>
                                <button class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> View</button>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editUser" v-on:click="getSelectedUserDetails( user.id )"> <i class="fa fa-edit"></i> Edit</button>
                                <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Delete </button>
                            </td>
                            <td>
                                {{ user.created_at | date }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label> Name </label>
                            <input v-model="form.name" type="text" name="name" placeholder="Name"
                                class="form-control" :class="{'is-invaild': form.errors.has('name')}">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Email </label>
                            <input v-model="form.email" type="text" name="email" placeholder="Email"
                                class="form-control" :class="{'is-invaild': form.errors.has('email')}">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Phone Number </label>
                            <input v-model="form.phone" type="text" name="phone" placeholder="Phone Number"
                                class="form-control" :class="{'is-invaild': form.errors.has('phone')}">
                            <has-error :form="form" field="phone"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Choose Role </label>
                            <b-form-select multiple
                                v-model="form.role"
                                :options="roles"
                                text-field="name"
                                value-field="name"

                            ></b-form-select>
                            <!-- <label class="typo__label">Tagging</label> -->
                                <!-- <multiselect v-model="form.role"  
                                tag-placeholder="Add this as new tag" 
                                placeholder="Search or add a tag" 
                                label="name" track-by="code" :options="roles" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                <pre class="language-json"><code>{{  value }}</code></pre> -->
                               <!-- <b-form-select v-model="form.role" text-field="name" :options="roles" value-field="id" multiple :select-size="4"></b-form-select> -->
                                <!-- <div class="mt-3">Selected: <strong>{{ selected }}</strong></div> -->
                                <!-- <component 
                                     v-model="roles" 
                                     :all-values="roles"
                                    :is-multi="true"
                                    :is-search="true"
                                    is="multiselect" 
                                   >
                                     </component> -->
                            <has-error :form="form" field="role"></has-error>

                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input v-model="form.password" type="password" name="password" placeholder="Password"
                                class="form-control" :class="{'is-invaild': form.errors.has('password')}">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                        <b-form-group label="Assign Permissions">
                            <b-form-checkbox
                                v-for="option in permissions"
                                v-model="form.permissions"
                                :key="option.name"
                                :value="option.name"
                                name="flavour-3a"
                            >
                                {{ option.name }}
                            </b-form-checkbox>
                        </b-form-group>

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit"  @click.prevent="createUser()" class="btn btn-lg btn-primary">Save User</button>
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label> Name </label>
                            <input v-model="editform.name" type="text" name="name" placeholder="Name"
                                class="form-control" :class="{'is-invaild': form.errors.has('name')}">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Email </label>
                            <input v-model="editform.email" type="text" name="email" placeholder="Email"
                                class="form-control" :class="{'is-invaild': form.errors.has('email')}">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Phone Number </label>
                            <input v-model="editform.phone" type="text" name="phone" placeholder="Phone Number"
                                class="form-control" :class="{'is-invaild': form.errors.has('phone')}">
                            <has-error :form="form" field="phone"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Choose Role </label>
                            <b-form-select multiple
                                v-model="editform.role"
                                :options="roles"
                                text-field="name"
                                value-field="name"

                            ></b-form-select>
                            <!-- <label class="typo__label">Tagging</label> -->
                                <!-- <multiselect v-model="form.role"  
                                tag-placeholder="Add this as new tag" 
                                placeholder="Search or add a tag" 
                                label="name" track-by="code" :options="roles" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                <pre class="language-json"><code>{{  value }}</code></pre> -->
                               <!-- <b-form-select v-model="form.role" text-field="name" :options="roles" value-field="id" multiple :select-size="4"></b-form-select> -->
                                <!-- <div class="mt-3">Selected: <strong>{{ selected }}</strong></div> -->
                                <!-- <component 
                                     v-model="roles" 
                                     :all-values="roles"
                                    :is-multi="true"
                                    :is-search="true"
                                    is="multiselect" 
                                   >
                                     </component> -->
                            <has-error :form="form" field="role"></has-error>

                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input v-model="form.password" type="password" name="password" placeholder="Password"
                                class="form-control" :class="{'is-invaild': form.errors.has('password')}">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                        <b-form-group label="Assign Permissions">
                            <b-form-checkbox
                                v-for="option in permissions"
                                v-model="editform.permissions"
                                :key="option.name"
                                :value="option.name"
                                name="flavour-3a"
                            >
                                {{ option.name }}
                            </b-form-checkbox>
                        </b-form-group>

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit"  @click.prevent="updateSelectedUser(editform.id)" class="btn btn-lg btn-primary">Save User</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
    data() {
        return {
            users: [],
            roles: [],
            permissions:[],
            form: new Form({
                'name': '',
                'phone': '',
                'password': '',
                'email': '',
                'permissions': [],
                'role': [],
            }),

             editform: new Form({
                 'id' :'',
                'name': '',
                'phone': '',
                'password': '',
                'email': '',
                'permissions': [],
                'role': [],
            }),
           
        }
    },
    methods:{
        getUsers(){
            axios.get('/getAllUsers').then((response) =>{
                this.users = response.data.users
                // this.users.forEach(element => {
                //     element.forEach(roles=>{
                //         console.log(roles)
                //     })
                // });
            }).catch(()=>{
               // this.$toastr.e("Cannot load users", "Error");
            })
        },
        getRoles(){
            axios.get('/getAllRoles').then((response) =>{
                this.roles = response.data.roles
            });
        },
        getAllPermission(){
            axios.get('/getAllPermissions').then((response) =>{
                this.permissions = response.data.permissions
            });
        },
        createUser(){
            this.form.post("/createUser").then(()=>{
                swal.fire({
                    icon: 'success',
                    title: 'User Created Successfully',
                    text: 'User Created Successfully',
                })
                // window.location = "/user";
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            });
            
        },
        getSelectedUserDetails(e) {
            this.editform.get("/getSelectedUserDetails/"+e).then((response)=>{
                this.resetEditFormData()
                this.editform.name = response.data.user.name
                this.editform.id = response.data.user.id
                this.editform.email = response.data.user.email
                this.editform.phone = response.data.user.phone
                for (var i = 0; i < response.data.roles.length; i++) {
                         this.editform.role.push(response.data.roles[i]);
                    }
                for (var i = 0; i < response.data.permissions.length; i++) {
                         this.editform.permissions.push(response.data.permissions[i]);
                    }
            }).catch((e)=>{
                console.log(e)
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.message,
                });
            });
        },
        updateSelectedUser(id){
            console.log(id)
            this.form.post("/updateSelectedUser/"+id).then(()=>{
                swal.fire({
                    icon: 'success',
                    title: 'User Edited Successfully',
                    text: 'User Edited Successfully',
                })
                // window.location = "/user";
            }).catch((e)=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.message,
                });
            });
            
        },
        resetEditFormData(){
            this.editform.id = ''
            this.editform.name = ''
            this.editform.email = ''
            this.editform.phone = ''
            this.editform.role = []
            this.editform.permissions = []
        }
    },
    created(){
        this.getUsers();
        this.getRoles();
        this.getAllPermission();
    }
}
</script>
