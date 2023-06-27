const PageSupport = {
   name: 'PageSupport',
   template: `
      <div v-if='$root.navigator == "support"' class='page-support'>
         <div class='appbar-wrapper'>
            <div class='appbar'>
               <div class='leading'>

                  <button @click='gotoConnector()' class='btn-action'>
                     <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="white"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="white"/>
                     </svg>
                  </button>
                  <p class='leading-title'>WaterGo Support</p>
                  
               </div>
               <div class='action'>
                  <button @click='gotoPage("support-notify")' class='btn-badge'>
                     <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M4.62643 18.9053C4.48098 19.0318 4.30247 19.1142 4.11185 19.1427C3.92123 19.1713 3.72642 19.1449 3.55029 19.0666C3.37416 18.9883 3.22401 18.8614 3.11748 18.7008C3.01096 18.5402 2.95246 18.3525 2.94888 18.1598V15.8876C2.41154 15.8876 1.89621 15.6741 1.51626 15.2942C1.13631 14.9142 0.922852 14.3989 0.922852 13.8615V6.77046C0.922852 6.23312 1.13631 5.7178 1.51626 5.33784C1.89621 4.95789 2.41154 4.74443 2.94888 4.74443H14.092C14.6294 4.74443 15.1447 4.95789 15.5246 5.33784C15.9046 5.7178 16.118 6.23312 16.118 6.77046V13.8615C16.118 14.3989 15.9046 14.9142 15.5246 15.2942C15.1447 15.6741 14.6294 15.8876 14.092 15.8876H9.02999L4.62643 18.9053ZM17.1311 10.8397C17.1278 10.9643 17.1278 11.089 17.1311 11.2135V10.8387C17.1361 10.7303 17.1371 9.37289 17.1351 6.76742C17.1343 5.96194 16.8138 5.18973 16.2439 4.62046C15.6741 4.05119 14.9015 3.73142 14.0961 3.73142H5.98792V2.71841C5.98792 2.18107 6.20137 1.66575 6.58132 1.28579C6.96128 0.905838 7.47661 0.692383 8.01394 0.692383L19.1571 0.692383C19.6944 0.692383 20.2097 0.905838 20.5897 1.28579C20.9697 1.66575 21.1831 2.18107 21.1831 2.71841V9.8095C21.1831 10.3468 20.9697 10.8622 20.5897 11.2421C20.2097 11.6221 19.6944 11.8355 19.1571 11.8355V14.1077C19.1535 14.3004 19.095 14.4881 18.9885 14.6487C18.8819 14.8094 18.7318 14.9363 18.5557 15.0146C18.3795 15.0928 18.1847 15.1192 17.9941 15.0907C17.8035 15.0621 17.625 14.9798 17.4795 14.8533L17.1311 14.6142V10.8397Z" fill="white"/>
                     </svg>
                     <span class='badge-circle'></span>
                  </button>
               </div>
            </div>

            <div class='appbar-bottom'>
               <div class='input-search'>
                  <input type="text" v-model='inputSearch' placeholder='Search by product or store name'>
                  <span class='icon-search'>
                     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M4.90688 0.60506C5.87126 0.205599 6.90488 0 7.94872 0C8.99256 0 10.0262 0.205599 10.9906 0.60506C11.9549 1.00452 12.8312 1.59002 13.5693 2.32813C14.3074 3.06623 14.8929 3.94249 15.2924 4.90688C15.6918 5.87126 15.8974 6.90488 15.8974 7.94872C15.8974 8.99256 15.6918 10.0262 15.2924 10.9906C14.9914 11.7172 14.5848 12.3938 14.0869 12.999L19.7747 18.6868C20.0751 18.9872 20.0751 19.4743 19.7747 19.7747C19.4743 20.0751 18.9872 20.0751 18.6868 19.7747L12.999 14.0869C12.3938 14.5848 11.7172 14.9914 10.9906 15.2924C10.0262 15.6918 8.99256 15.8974 7.94872 15.8974C6.90488 15.8974 5.87126 15.6918 4.90688 15.2924C3.94249 14.8929 3.06623 14.3074 2.32813 13.5693C1.59002 12.8312 1.00452 11.9549 0.60506 10.9906C0.2056 10.0262 0 8.99256 0 7.94872C0 6.90488 0.2056 5.87126 0.60506 4.90688C1.00452 3.94249 1.59002 3.06623 2.32813 2.32813C3.06623 1.59002 3.94249 1.00452 4.90688 0.60506ZM7.94872 1.53846C7.10691 1.53846 6.27335 1.70427 5.49562 2.02641C4.71789 2.34856 4.01123 2.82073 3.41598 3.41598C2.82073 4.01123 2.34856 4.71789 2.02641 5.49562C1.70427 6.27335 1.53846 7.10691 1.53846 7.94872C1.53846 8.79053 1.70427 9.62409 2.02641 10.4018C2.34856 11.1795 2.82073 11.8862 3.41598 12.4815C4.01123 13.0767 4.71789 13.5489 5.49562 13.871C6.27335 14.1932 7.10691 14.359 7.94872 14.359C8.79053 14.359 9.62409 14.1932 10.4018 13.871C11.1795 13.5489 11.8862 13.0767 12.4815 12.4815C13.0767 11.8862 13.5489 11.1795 13.871 10.4018C14.1932 9.62409 14.359 8.79053 14.359 7.94872C14.359 7.10691 14.1932 6.27335 13.871 5.49562C13.5489 4.71789 13.0767 4.01123 12.4815 3.41598C11.8862 2.82073 11.1795 2.34856 10.4018 2.02641C9.62409 1.70427 8.79053 1.53846 7.94872 1.53846Z" fill="#252831"/>
                     </svg>
                  </span>
               </div>
            </div>
         </div>


         <div class='support-content'>
            <div v-if='supports.length > 0' class='list-support'>
               <ul>
                  <li @click='supportDetail(item.id)' v-for='(item , index) in supports' :key='index'>
                     {{ item.question }}
                  </li>
               </ul>
            </div>

            <div v-if='supports.length == 0 '>
               <div class='banner-fixed'>
                  <div class='notify-wrapper'>
                     <img width='130' :src='banner_not_found'>
                     <p class='t-thrid'>No Results Match</p>
                  </div>
               </div>
            </div>
         </div>


         <div class='support-bottomsheet'>
            <p>Send message to tell us more and we’ll help you </p>
            <button @click='gotoPage("support-add")' class='btn btn-primary'>Send a Message</button>
         </div>

      </div>

      <div v-if='$root.navigator == "support-detail"' class='page-support'>

         <div class='appbar'>
            <div class='leading'>
               <button @click='gotoPage("support")' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>WaterGo Support</p>
            </div>
         </div>

         <div class='entry-content-support'>
            <div class='question'>
               {{ support_detail.question }}
            </div>
            <div class='answer'>
               {{ support_detail.answer }}
            </div>
         </div>

      </div>

      <div v-if='$root.navigator == "support-notify"' class='page-support'>
         <div class='appbar'>
            <div class='leading'>
               <button @click='gotoPage("support")' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
            </div>
         </div>
         <div v-if='supports.length > 0' class='list-support-notify'>
            <ul>
               <li :class='item.is_read == 0 ? "is_read" : ""' @click='supportDetailNotify(item.id)' v-for='(item , index) in get_list_support_notify' :key='index'>
                  <div class='time'>{{ convert_timestamp( item.time_answer ) }}</div>
                  <div class='question'>{{ item.question }} </div>
               </li>
            </ul>
         </div>
      </div>

      <div v-if='$root.navigator == "support-detail-notify"' class='page-support'>

         <div class='appbar'>
            <div class='leading'>
               <button @click='gotoPage("support-notify")' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>WaterGo Support</p>
            </div>
         </div>

         <div class='entry-content-support'>
            <div class='time'> {{ convert_time }} </div>
            <div class='question'>
               {{ support_detail.question }}
            </div>
            <div class='answer'>
               {{ support_detail.answer }}
            </div>
         </div>

      </div>

      <div v-if='$root.navigator == "support-add"' class='page-support'>
         <div class='appbar'>
            <div class='leading'>
               <button @click='gotoPage("support")' class='btn-action'>
                  <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8C0 7.44772 0.447715 7 1 7H18.5C19.0523 7 19.5 7.44772 19.5 8C19.5 8.55228 19.0523 9 18.5 9H1C0.447715 9 0 8.55228 0 8Z" fill="#252831"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
                  </svg>
               </button>
               <p class='leading-title'>WaterGo Support</p>
            </div>
         </div>

         <div class='form-question'>
            <p>Your Question</p>
            <textarea v-model='question' placeholder='Enter your question'></textarea>
            <p class='t-red'>{{text_res}}</p>
         </div>

         <div class='support-bottomsheet no-shadow'>
            <button @click='supportAdd' class='btn btn-primary'>Send Message</button>
         </div>

      </div>




   `,
   data(){
      return {
         connector: '',
         banner_not_found: get_template_directory_uri + '/assets/images/icon-support-search.png',
         supports: [],
         support_detail: null,
         question: '',
         text_res: ''
      }
   },
   methods: {
      request( formdata ){
         try{
            return axios({ method: 'post', url: get_ajaxadmin, data: formdata
            }).then(function (res) { 
               return res.status == 200 ? res.data.data : null;
            });
         }catch(e){
            console.log(e);
            return null;
         }
      },

      gotoPage(page){ 
         if( page == 'support_add' ){
            this.resetForm();
         }
         this.$root.gotoPage( page ); 
      },

      resetForm(){
         this.question = '';
      },

      gotoConnector(){
         if( this.connector == 'user' ){
            this.$root.gotoProfile();
         }
      },
      
      supportDetail( id ){
         this.$root.gotoPage('support-detail');
         this.supports.forEach(( item ) => {
            if( item.id == id ){
               this.support_detail = item;
            }
         } );
      },

      async supportDetailNotify( id ){
         this.$root.gotoPage('support-detail-notify');
         this.supports.forEach(( item ) => {
            if( item.id == id ){
               this.support_detail = item;
            }
         } );

         // SET ITEM ALREADY READ
         this.supports.forEach( async ( item ) => { 
            if(item.id == id && item.is_read == 0 ){
               var form = new FormData();
               form.append('action', 'atlantis_support');
               form.append('event', 'read');
               form.append('support_id', id);
               var r = await this.request( form);
               if( r != undefined ){
                  var res = JSON.parse( JSON.stringify(r));
                  if(res.message == 'question_has_read' ){
                     item.is_read = 1;
                  }
               }
            }
         });

      },

      async supportAdd(){
         if( this.question == null || this.question == undefined || this.question == '' ){
            this.text_res = 'Question must be not empty';
         }else{
            this.text_res = '';
            var form = new FormData();
            form.append('action', 'atlantis_support');
            form.append('event', 'add');
            form.append('question', this.question);
            var r = await this.request(form);
            if( r != undefined ){
               var res = JSON.parse( JSON.stringify(r));
               if( res.message == 'question_add_ok' ){
                  this.supports.push( res.data );
                  this.gotoPage('support');
                  this.question = '';
                  console.log(res);
               }
            }
         }

      },

      convert_timestamp( timestamp ){
         if( timestamp == undefined || timestamp == null ) return '';
         var date = new Date(timestamp * 1000 );
         return date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear();
      }

   },

   computed: {

      convert_time(){
         if( this.support_detail != null ){
            var date = new Date(this.support_detail.time_created * 1000 );
            return date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear();
         }
         return '';
      },

      get_list_support_notify(){
         return this.supports.filter((item, index ) => item.time_answer != null );
      }

   },

   async created(){
      var form = new FormData();
      form.append('action', 'atlantis_support');
      form.append('event', 'get');
      if( this.supports.length == 0 ){
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'get_support_ok' ){
               this.supports.push( ...res.data);
            }
         }
      };
   },

   mounted(){

      if( this.$root.pageNameConnector != undefined ){
         this.connector = this.$root.pageNameConnector;
      }

   }
};

