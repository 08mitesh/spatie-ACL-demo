<template>
    <form>
        
        <div class="modal-body">
            <div class="form-group">
                <input v-model="form.name" type="text" name="name" placeholder="Role Name"
                    class="form-control" :class="{'is-invaild': form.errors.has('name')}">
                <has-error :form="form" field="name"></has-error>
            </div>
            
            <b-form-group label="Assign Permissions">
                <b-form-checkbox
                    v-for="option in permissions"
                    v-model="form.permissions"
                    :key="option.name"
                  
                   
                   v-bind:value="option.name"
                >
                    {{ option.name }}
                </b-form-checkbox>
            </b-form-group>


        </div>
        <div class="modal-footer justify-content-between">
            <b-button type="submit" variant="primary" class="btn-lg btn-primary" v-if="!dis" disabled><b-spinner small type="grow"></b-spinner>Creating Role</b-button>
            <button type="submit"  v-if="dis" @click.prevent="updateRole()" class="btn btn-lg btn-primary"><i class="fas fa-save"></i> Save Role</button>
        </div>
    </form>
</template>

<script>
export default {
    props: ['role_id'],
    data(){
        return{
            dis: true,
            permissions: [],
            form: new Form({
                'name' : '',
                permissions : []
            }),
            // role_id1 : role_id
        }
    },
    methods:{
        getAssociatedRolesPermissions(){
            axios.get("/getAssociatedRolesPermissions/"+this.role_id)
            .then((response)=>{
                console.log(response);
                var arr = [];

            this.form.name = response.data.name

            //pushing permissions id into array
            for (var i = 0; i < response.data.permissions.length; i++) {
                         this.form.permissions.push(response.data.permissions[i].name);
                    }
            }).catch((e)=>{
                // console.log(e)
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.message,
                })
            });
        },
        getAllPermissions(){
            axios.get("/getAllPermissions")
            .then((response)=>{
                this.permissions = response.data.permissions
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            });
        },
        updateRole(){
            this.dis = false;
            this.form.post("/updateRole/"+this.role_id).then(()=>{
                swal.fire({
                    icon: 'success',
                    title: 'Role updated',
                    text: 'Your Role has been updated',
                })
                window.location = "/role";
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            });
            // this.dis=true;
        }
    },
    created(){
        this.getAllPermissions();
       
        
    },
    mounted() {
        this.getAssociatedRolesPermissions();
    }
}
</script>

