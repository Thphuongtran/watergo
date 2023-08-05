const LocationModal = {
   name: 'LocationModal',
   template: `
      <div v-if='modal_location_turned_off == true' class='modal-popup open'>
         <div class='modal-wrapper'>
            <div class='modal-close'><div @click='buttonCloseModal' class='close-button'><span></span><span></span></div></div>
            <p class='heading pt20'>Location information is not available</p>
            <p>Please share your location for a better experience on Watergo</p>
            <button @click='open_app_setting' class='btn btn-primary mt20'>Allow Access</button>
         </div>
      </div>
   `,

   data(){
      return{
         modal_location_turned_off: false,
      }
   },

   methods: {
      buttonCloseModal(){ this.modal_location_turned_off = false; window.bodyScrollToggle('remove'); },

      open_app_setting() {
         if(window.appBridge){
            window.appBridge.openAppSetting();
         }
      },

      get_current_location(){ 

         // setInterval( () => {
            if( window.appBridge !== undefined ){
               window.appBridge.getLocation().then( (data) => {
                  if (Object.keys(data).length === 0) {
                     //alert("Error-1 :Không thể truy cập vị trí");
                     this.modal_location_turned_off = true;
                     window.bodyScrollToggle('add');
                     this.location_realtime = false;
                  }else{
                     this.modal_location_turned_off = false;
                     window.bodyScrollToggle('remove');
                     // let lat = data.lat;
                     // let lng = data.lng;
                     // this.latitude  = lat;
                     // this.longitude = lng;
                     
                  }
               }).catch((e) => { })
            }
         // }, 1500);

      },
   },

   update(){
      this.get_current_location();
   },

   mounted(){
      this.get_current_location();
   }
   
};


// COMPONENT EDIT
