<div id='app'>
  <div v-if='!loading' class='business-store-edit-profile'>
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div>
      <form class='form-edit-profile' v-on:submit.prevent>
        <div class='edit-profile-cover-image'>
          <div class='image-container'>
            <div
              v-if='!store.coverImage'
              class='image-skeleton-container'
            >
              <div class='image-skeleton-logo-container'>
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="31" viewBox="0 0 38 31" fill="none">
                  <rect x="4.52942" y="11.9199" width="28" height="18.0197" rx="1" fill="white" stroke="#C9C9C9" stroke-width="2"/>
                  <path d="M35.356 8.09906L35.3558 8.09881L31.4509 1.46755L31.4499 1.46586C31.2711 1.16085 30.971 1 30.6821 1H6.37438C6.08548 1 5.78533 1.16085 5.60652 1.46586L5.60554 1.46755L1.70076 8.09865C1.70073 8.0987 1.70069 8.09876 1.70066 8.09881C0.186879 10.6709 1.26138 14.0345 3.53867 15.0502C3.84046 15.1848 4.16734 15.2814 4.51873 15.3323C4.74145 15.3638 4.97076 15.3797 5.20111 15.3797C6.65767 15.3797 7.96368 14.7014 8.87645 13.6171L9.64148 12.7083L10.4065 13.6171C11.3189 14.7009 12.6308 15.3797 14.0818 15.3797C15.5384 15.3797 16.8444 14.7014 17.7572 13.6171L18.5222 12.7083L19.2873 13.6171C20.1996 14.7009 21.5115 15.3797 22.9626 15.3797C24.4191 15.3797 25.7252 14.7014 26.6379 13.6171L27.4008 12.7108L28.1662 13.615C29.0864 14.7021 30.3937 15.3797 31.8433 15.3797C32.0795 15.3797 32.3032 15.3638 32.5267 15.3321L35.356 8.09906ZM35.356 8.09906C36.1977 9.52756 36.2515 11.2502 35.6879 12.6735M35.356 8.09906L35.6879 12.6735M35.6879 12.6735C35.1265 14.0913 33.9963 15.1228 32.5272 15.3321L35.6879 12.6735Z" fill="white" stroke="#C9C9C9" stroke-width="2"/>
                </svg>
              </div>
            </div>
            <div
              v-if='store.coverImage'
              class='cover-image-container'
            >
              <img :src="store.coverImage" alt="cover image" />
            </div>
            <div class='upload-image-btn'>
              <label>
                <input type="file" v-on:change='handleUploadImage' />
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                  <path d="M9.88134 12.7934C11.4523 12.7934 12.7258 11.5199 12.7258 9.94894C12.7258 8.37799 11.4523 7.10449 9.88134 7.10449C8.3104 7.10449 7.0369 8.37799 7.0369 9.94894C7.0369 11.5199 8.3104 12.7934 9.88134 12.7934Z" fill="#252831"/>
                  <path d="M17.4667 2.36309H14.461L13.2853 1.08309C13.1086 0.889096 12.8934 0.734087 12.6534 0.627969C12.4134 0.521851 12.154 0.466958 11.8915 0.466797H7.8714C7.34044 0.466797 6.82844 0.694353 6.46814 1.08309L5.30192 2.36309H2.29629C1.25333 2.36309 0.399994 3.21643 0.399994 4.25939V15.6372C0.399994 16.6801 1.25333 17.5335 2.29629 17.5335H17.4667C18.5096 17.5335 19.363 16.6801 19.363 15.6372V4.25939C19.363 3.21643 18.5096 2.36309 17.4667 2.36309ZM9.88147 14.689C7.26459 14.689 5.14073 12.5652 5.14073 9.94828C5.14073 7.33139 7.26459 5.20754 9.88147 5.20754C12.4984 5.20754 14.6222 7.33139 14.6222 9.94828C14.6222 12.5652 12.4984 14.689 9.88147 14.689Z" fill="#252831"/>
                </svg>
              </label>
            </div>
          </div>
        </div>
        <div class='input-container'>
          <label>Owner</label>
          <input type="text" :value='store.owner'>
        </div>
        <div class='input-container'>
          <label>Store Name</label>
          <input type="text" :value='store.name'>
        </div>
        <div class='input-container'>
          <label>Description</label>
          <textarea>{{ store.description }}</textarea>
        </div>
        <div class='input-container'>
          <label>Address</label>
          <input type="text" :value='store.address'>
        </div>
        <div class='input-container'>
          <label>Phone</label>
          <input type="text" :value='store.phone'>
        </div>
        <div class='input-container'>
          <label>Email</label>
          <input type="text" :value='store.email'>
        </div>
        <div class='save-btn-container'>
          <button>Save</button>
        </div>
      </form>
    </div>
  </div>


  <div v-if='loading == true'>
    <div class='progress-center'>
      <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
    </div>
  </div>
</div>
<script type='module'>
  const { createApp } = Vue;

  createApp({
    data() {
      return {
        loading: false,
        detailBarTitle: "Edit Info",
        store: {
          coverImage: "",
          owner: "Jennie Huỳnh",
          name: 'Store 1',
          description: "Lorem ipsum dolor sit amet, consectetur adipis, con sec tetur adipis, Lorem ipsum dol sit amet, consectetur adipis, con sec tetur adipis.",
          address: "12 Điện Biên, District 2, HCMC",
          phone: "000-000-0000",
          email: "Jennie@gmail.com",
        },
      }
    },
    methods: {
      goBack() {
        window.redirectBack();
      },
      loadImage() {
        return new Promise((resolve, reject) => {
          setTimeout(() => {
            const image = "https://64.media.tumblr.com/7ad9b1d2abc19e546f91332039c6524a/9b2772ab420f1d6f-22/s400x600/a20d8f56285bd2560bb73a59c448bb6db28be125.png";
            resolve(image);
          }, 1000);
        });
      }
    },
    computed: {
      getCoverImage() {
        const imageLoader = (async () => {
          const image = await this.loadImage();
          return image;
        })();

        if (!imageLoader || imageLoader === this.coverImage) {
          return "";
        }
        return imageLoader;
      }
    },
    async created() {
      this.loading = true;
      this.loading = false;
    }
  }).mount("#app");
</script>