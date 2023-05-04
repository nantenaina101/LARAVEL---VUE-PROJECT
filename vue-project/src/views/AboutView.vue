<template>
  <div class="about">
    <h1>A propos</h1>
    <button @click="redirectMe()">Redirect Me</button>
    <button @click="{ isLoggedIn ? $router.push('/dashboard') : $router.push('/login'); }">
      Authenticate Me
   </button>
   <button @click="checkUser()">Authenticate Me</button>
  </div>
</template>
<script>
   export default {
      data() {
         return {
            isLoggedIn: true,
         };
      },
      methods: {
         redirectMe() {
            setTimeout(() => this.$router.push('/'), 5000)
         },
         checkUser() {
            if(this.isLoggedIn){
               this.$router.push('/dashboard');
            }else{
               this.$router.push('/login');
               // Descriptor object with path
              //$router.push({ path: '/about' })

              // Named route 
              //$router.push({ name: 'About' })
              //router.push({ path: '/about', replace: true })
              // This is equivalent to
              //router.replace({ path: '/about' })
                          }
         },
      },
   };
</script>
