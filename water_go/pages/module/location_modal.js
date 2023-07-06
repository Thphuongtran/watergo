const LocationModal = {
   name: 'LocationModal',
   template: `
      <div v-if='modal_location_turned_off == true' class='modal-popup open'>
         <div class='modal-wrapper'>
            <div class='modal-close'><div @click='buttonCloseModal' class='close-button'><span></span><span></span></div></div>
            <p class='heading'>Location information is not available</p>
            <p>Please share your location for a better experience on Watergo</p>
            <button @click='open_app_setting' class='btn btn-primary'>Allow Access</button>
         </div>
      </div>
   `,

   data(){
      return{
         modal_location_turned_off: false,
      }
   },

   methods: {
      buttonCloseModal(){ this.modal_location_turned_off = false; },

      open_app_setting() {
         if(window.appBridge){
            window.appBridge.openAppSetting();
         }
      },

      get_current_location(){
         if( window.appBridge !== undefined ){
            window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
                  //alert("Error-1 :Không thể truy cập vị trí");
                  this.modal_location_turned_off = true;
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  if( lat != 37.4226711 ){
                     this.latitude = lat;
                     this.longitude =lng;
                  }
               }
            }).catch((e) => { alert(e); })
         }
      },
   },


   async mounted(){
      this.get_current_location();      
   }
   
};


// COMPONENT EDIT
