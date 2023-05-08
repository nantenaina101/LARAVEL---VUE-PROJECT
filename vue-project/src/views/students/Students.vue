<script>

import { RouterLink } from 'vue-router';

import axios from 'axios';

export default {
    name : 'students',
    successMessage : "",
    isSuccessMessage : false,
    data(){
      return {
        students : []
      }
    },
    mounted(){
      this.getStudents();
    },
    methods: {
         getStudents(){
            axios.get("http://localhost:8000/api/students")
            .then(result => {
              //console.log(result);
              this.students = result.data
            })
            .catch(error => {
              console.log(error);
            })
         },
        deleteStudent(id){
            this.isSuccessMessage = false
            axios.delete("http://localhost:8000/api/student/"+id)
            .then(result => {
              console.log(result);
              this.successMessage = result.data.message
              //this.getStudents();
              this.students = this.students.filter(student => student.id != id)

              setTimeout(() => {
                this.isSuccessMessage = false
              }, 5000)

            })
            .catch(error => {
              console.log(error);
            })
         }
      },
  }
</script>
<template>
    <div class="etudiants row mt-4">
      <div class="col-2"></div>
      <div class="col-8">
         <div class="mb-4">
            <h2>List des étudiants
              <RouterLink to="/add" class="btn btn-primary float-end">Ajouter</RouterLink>
            </h2>
         </div>

          <div v-if="this.successMessage">
              <h6 class="text-success">{{ this.successMessage }}</h6>
          </div>
        
         <table class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Nom</th>
                     <th>Cours</th>
                     <th>Email</th>
                     <th>Téléphone</th>
                     <th>Photo</th>
                     <th>Actions</th>
                  </tr>
               </thead>
               <tbody v-if="this.students.length > 0">
                
                     <tr class="etudiant-card align-middle" v-for="(item, index) in this.students" :key="index">
                        <td class="etudiant-id">{{ index + 1 }}</td>
                        <td class="etudiant-name">{{ item.name }}</td>
                        <td class="etudiant-cours">{{ item.course }}</td>
                        <td class="etudiant-email">{{ item.email }}</td>
                        <td class="etudiant-phone">{{ item.phone }}</td>
                        <td style="text-align:center"><img :src="'/uploads/'+item.image" width='50' class='img-thumbnail' /></td>
                        <td class="actions text-center">
                          <RouterLink :to="{path:'/edit/'+item.id}" class="btn btn-primary">Modifier</RouterLink>
                           &nbsp;&nbsp;
                           <button @click="this.deleteStudent(item.id)" class="btn btn-danger ml-3">Supprimer</button></td>
                     </tr>

               </tbody>
               <tbody v-else>
                  <tr class="text-center">
                    <td colspan="7">Aucun enregistrement</td>
                  </tr>
               </tbody>
         </table>
      </div>
      <div class="col-2"></div>
      
   </div>
  </template>
