<template>
  <div class="hidden">
    <vs-sidebar
      v-model="active"
      background="#134C41"
      style="z-index: 980 !important; color: white !important;"
      hover-expand
      open
      notShadow
      fixed
      :reduce="reduceValue"
    >
      <vs-sidebar-item
        id="dash"
        to="/home"
        style="margin-top: 100px; color: white !important;"
      >
        <template #icon>
          <i class="fas fa-home"></i>
        </template>
        Home
      </vs-sidebar-item>

      <!-- Farms Menu -->
      <vs-sidebar-item
        id="farm"
        to="/farm"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-tractor"></i>
        </template>
        Farms
      </vs-sidebar-item>

      <!-- Products Menu -->
      <vs-sidebar-item
        id="product"
        to="/product"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-seedling"></i>
        </template>
        Products
      </vs-sidebar-item>

      <!-- Categories Menu -->
      <vs-sidebar-item
        id="category"
        to="/category"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-tags"></i>
        </template>
        Categories
      </vs-sidebar-item>

      <!-- Orders Menu -->
      <vs-sidebar-item
        id="order"
        to="/order"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-shopping-cart"></i>
        </template>
        Orders
      </vs-sidebar-item>

      <!-- Delivery Menu -->
      <vs-sidebar-item
        id="delivery"
        to="/delivery"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-truck"></i>
        </template>
        Deliveries
      </vs-sidebar-item>

      <!-- Reviews Menu -->
      <vs-sidebar-item
        id="review"
        to="/review"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-star"></i>
        </template>
        Reviews
      </vs-sidebar-item>

      <!-- User Management -->
      <vs-sidebar-item
        id="user"
        to="/user"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-users"></i>
        </template>
        Users
      </vs-sidebar-item>

      <!-- Analytics -->
      <vs-sidebar-item
        id="analytic"
        to="/analytic"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-chart-pie"></i>
        </template>
        Analytics
      </vs-sidebar-item>

      <!-- Settings -->
      <vs-sidebar-item
        id="setting"
        to="/setting"
        style="color: white !important;"
      >
        <template #icon>
          <i class="fas fa-cog"></i>
        </template>
        Settings
      </vs-sidebar-item>

      <!-- Logout -->
      <vs-sidebar-item style="color: white !important;">
        <template #icon>
          <button @click="logout" style="background: none; border: none; color: white !important;">
            <i class="fas fa-sign-out-alt"></i>
          </button>
        </template>
        <button style="background: none; border: none; color: white !important;" @click="logout">
          Logout
        </button>
      </vs-sidebar-item>

    </vs-sidebar>
  </div>
</template>

<script>
import Network from "../network-class";
export default {
  created() {
    this.getUser();
  },
  data() {
    return {
      active: 'home',
      user: null,
      moreProperty: false,
      moreSetting: false,
      reduceValue: true,
    };
  },
  methods: {
    getUser() {
      const userData = localStorage.getItem('user');
      if (userData) {
        try {
          this.user = JSON.parse(userData);
        } catch (e) {
          console.error('Error parsing user data:', e);
          this.user = null;
        }
      }
    },
    showMoreProperty() {
      this.moreProperty = !this.moreProperty;
    },
    showMoreSetting() {
      this.moreSetting = !this.moreSetting;
    },
    toggleTab(tab) {
      this.active = tab;
    },
    logout: async function(){
      try {
        var url='/api/logout';
        const data = await Network.get(url);
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('auth');
        this.$store.commit('getUser');
        this.$router.push('/login');
      } catch (error) {
        console.error('Logout error:', error);
        // Force logout even if API call fails
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('auth');
        this.$router.push('/login');
      }
    },
  },
};
</script>