<script>

import { RouterLink } from 'vue-router';

import axios from 'axios';

export default {
    notFound : false,
    name : 'edit',
    data(){
      return {
        id : this.$route.params.id,
        model : {
               student : {
                     name : "", 
                     course: "", 
                     email: "", 
                     phone: ""
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
      //console.log("params : " + this.$route.params.id);
      this.getStudent()
    },
    methods: {

         getStudent(){
            axios.get("http://localhost:8000/api/student/"+this.id)
            .then(result => {
              console.log(result);
              //this.student = result.data
              this.model.student.name = result.data.name
              this.model.student.email = result.data.email
              this.model.student.course = result.data.course
              this.model.student.phone = result.data.phone
            })
            .catch(error => {
              //console.log(error);
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
            axios.put("http://localhost:8000/api/student/"+this.id, this.model.student)
                  .then(res => {
                     //console.log(res);
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
                  <button type="button" @click = "this.updateStudent()" class="btn btn-primary">Modifier</button>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                  <div class="mt-3">
                     
                  </div>
               </div>
            </div>
            
         </form>
      </div>
      <div class="col-3"></div>

   </div>
</template>
