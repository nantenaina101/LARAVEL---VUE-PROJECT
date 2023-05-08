<script>

import { RouterLink } from 'vue-router';

import axios from 'axios';

export default {
    name : 'edit',
    data(){
      return {
         notFound : false,
        id : this.$route.params.id,
        imgURL : null,
        model : {
               student : {
                     name : "", 
                     course: "", 
                     email: "", 
                     phone: "",
                     image: null
               }
            },
         errors : {
            name : "", 
            course: "", 
            email: "", 
            phone: ""
         }
      }
    },
    mounted(){
      this.getStudent()
    },
    methods: {

         getStudent(){
            axios.get("http://localhost:8000/api/student/"+this.id)
            .then(result => {
              console.log(result);
              this.model.student = result.data
              
            })
            .catch(error => {
               if(error.response.status == 404){
                  this.notFound = true
                  console.log(this.notFound);
               }
            })
         },
         
         updateStudent(){

            this.errors = {
               name : "", 
               course: "", 
               email: "", 
               phone: ""
            }

            const formData = new FormData()

            formData.append('_method', 'PUT');

            formData.append('name', this.model.student.name)

            formData.append('course', this.model.student.course)

            formData.append('email', this.model.student.email)

            formData.append('phone', this.model.student.phone)

            formData.append('image', this.model.student.image)

            axios.post("http://localhost:8000/api/student/"+this.id, formData, {})
                  .then(res => {
                     this.$router.push('/students');
                  }).catch(err => {
                     console.log(err.response);
                     if(err.response.data.message.name){
                        this.errors.name = err.response.data.message.name[0]
                     }
                     if(err.response.data.message.course){
                        this.errors.course = err.response.data.message.course[0]
                     }
                     if(err.response.data.message.email){
                        this.errors.email = err.response.data.message.email[0]
                     }
                     if(err.response.data.message.phone){
                        this.errors.phone = err.response.data.message.phone[0]
                     }
                     if(err.response.status == 404){
                        console.log(err.response.data);
                        this.notFound = true
                     }
                  })
         },
         handleChange(e){
            this.model.student.image = e.target.files[0]
            this.imgURL = URL.createObjectURL(e.target.files[0])
         }
      },
  }
</script>
<template>
    <div class="etudiants row mt-4">
      <div class="col-3"></div>
      <div class="col-6" v-if="this.notFound == true">
         <h3 class="text-danger">Aucun étudiant trouvé !!!
            <RouterLink to="/students" class="btn btn-danger float-end">Retour</RouterLink>
         </h3>
      </div>
      <div class="col-6" v-else>
         <h3>Modifier un étudiant
            <RouterLink to="/students" class="btn btn-danger float-end">Retour</RouterLink>
         </h3>
         <form>
            <div class="row">
               <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                  <div class="form-group">
                     <label for="name">Nom</label>
                     <input type="text" v-model="model.student.name" name="name" class="form-control" id="name"  />
                  </div>
                  <span class="text-danger">{{ this.errors.name }}</span>
               </div>

               <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                  <div class="form-group">
                     <label for="course">Cours</label>
                     <input type="text" v-model="model.student.course" name="course" class="form-control" id="course"  />
                  </div>
                  <span class="text-danger">{{ this.errors.course }}</span>
               </div>

               <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                  <div class="form-group">
                     <label for="email">Email</label>
                     <input type="email" v-model="model.student.email" name="email" class="form-control" id="email"  />
                  </div>
                  <span class="text-danger">{{ this.errors.email }}</span>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                  <div class="form-group">
                     <label for="phone">Téléphone</label>
                     <input type="phone" v-model="model.student.phone" name="phone" class="form-control" id="phone" />
                  </div>
                  <span class="text-danger">{{ this.errors.phone }}</span>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                  <div class="form-group">
                     <label for="phone">Photo</label>
                     <input type="file" name="photo" class="form-control" id="photo" accept="image/*" @change="this.handleChange($event)" />
                  </div>
               </div>

               <div v-if="this.imgURL" className="col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div className="mt-3">
                     <img :src="this.imgURL" width='100' height='100' />
                  </div>
               </div>
               <div v-else className="col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div className="mt-3">
                     <img :src="'/uploads/'+this.model.student.image" width='100' height='100' />
                  </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                  <button type="button" @click = "this.updateStudent()" class="btn btn-primary">Modifier</button>
               </div>
               
            </div>
            
         </form>
      </div>
      <div class="col-3"></div>

   </div>
</template>
