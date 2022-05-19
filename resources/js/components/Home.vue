 <template>
  <h1>Home Components</h1>
  <div>
    <router-link :to="{ name: 'login' }">Login</router-link> &nbsp;
    <router-link :to="{ name: 'register' }">Register</router-link>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>