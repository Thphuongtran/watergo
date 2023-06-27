<div id='app'>

   <div v-if='loading == false'>

      <div v-if='navigator == "home"' class='page-home'>
         <div class='appbar'>
            <div class='leading'>
               <span class='leading-title'>Home</span>
            </div>
            <div class='action'>
               <div @click='gotoPage("cart", {back: "home"})' class='btn-badge'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.05036 18.4583C9.05036 18.7245 8.97134 18.9846 8.82329 19.2059C8.67524 19.4272 8.46481 19.5997 8.21861 19.7015C7.97241 19.8034 7.7015 19.83 7.44014 19.7781C7.17878 19.7262 6.9387 19.598 6.75027 19.4098C6.56184 19.2216 6.43352 18.9819 6.38153 18.7208C6.32954 18.4598 6.35622 18.1892 6.4582 17.9434C6.56018 17.6975 6.73288 17.4873 6.95445 17.3395C7.17602 17.1916 7.43652 17.1127 7.703 17.1127C8.06034 17.1127 8.40305 17.2544 8.65573 17.5068C8.9084 17.7592 9.05036 18.1014 9.05036 18.4583ZM17.7119 17.1127C17.4455 17.1127 17.185 17.1916 16.9634 17.3395C16.7418 17.4873 16.5691 17.6975 16.4672 17.9434C16.3652 18.1892 16.3385 18.4598 16.3905 18.7208C16.4425 18.9819 16.5708 19.2216 16.7592 19.4098C16.9477 19.598 17.1877 19.7262 17.4491 19.7781C17.7105 19.83 17.9814 19.8034 18.2276 19.7015C18.4738 19.5997 18.6842 19.4272 18.8322 19.2059C18.9803 18.9846 19.0593 18.7245 19.0593 18.4583C19.0593 18.1014 18.9174 17.7592 18.6647 17.5068C18.412 17.2544 18.0693 17.1127 17.7119 17.1127ZM22.113 4.78665L19.3682 13.6976C19.2367 14.1303 18.9691 14.5092 18.605 14.778C18.241 15.0469 17.8 15.1915 17.3472 15.1903H8.0947C7.63433 15.1886 7.18695 15.0378 6.81974 14.7605C6.45253 14.4832 6.18533 14.0944 6.05826 13.6525L2.57823 1.48888C2.56669 1.44861 2.54231 1.41321 2.50878 1.38805C2.47525 1.36289 2.43442 1.34936 2.39248 1.34951H0.773728C0.620582 1.34951 0.473708 1.28875 0.365417 1.1806C0.257126 1.07244 0.196289 0.925758 0.196289 0.772807C0.196289 0.619857 0.257126 0.47317 0.365417 0.365018C0.473708 0.256865 0.620582 0.196106 0.773728 0.196106H2.39248C2.68501 0.196894 2.9694 0.292405 3.20296 0.468308C3.43652 0.644211 3.60667 0.891018 3.68787 1.17169L4.5088 4.04078H21.5615C21.6518 4.04087 21.7408 4.0621 21.8214 4.10276C21.902 4.14342 21.9719 4.20239 22.0255 4.27491C22.0791 4.34744 22.115 4.43152 22.1302 4.52039C22.1454 4.60926 22.1395 4.70046 22.113 4.78665ZM20.7801 5.19418H4.8389L7.16887 13.3401C7.22639 13.5409 7.34788 13.7176 7.51493 13.8434C7.68199 13.9691 7.88551 14.0371 8.0947 14.0369H17.3443C17.5502 14.037 17.7506 13.9711 17.9162 13.849C18.0818 13.7268 18.2038 13.5549 18.2644 13.3584L20.7801 5.19418Z" fill="#2040AF"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3002 4.84434L19.5556 13.7547C19.4118 14.2275 19.1191 14.6419 18.7213 14.9357C18.3234 15.2296 17.8413 15.3876 17.3465 15.3864H8.09448C7.59174 15.3845 7.10242 15.2198 6.70136 14.917C6.3003 14.6141 6.00841 14.1894 5.86961 13.7066L2.39029 1.54556H0.773518C0.568449 1.54556 0.371729 1.4642 0.226647 1.31931C0.0815564 1.1744 0 0.977815 0 0.77278C0 0.567745 0.0815564 0.371158 0.226647 0.226253C0.371729 0.0813567 0.568449 0 0.773518 0H2.39227C2.72716 0.000902557 3.05328 0.110242 3.32071 0.311653C3.58815 0.513066 3.78301 0.795701 3.87602 1.11717L4.65643 3.84467H21.5613C21.6822 3.8448 21.8016 3.87322 21.9095 3.92768C22.0174 3.98214 22.1111 4.06113 22.1829 4.15832C22.2548 4.25551 22.3028 4.36819 22.3232 4.48731C22.3436 4.60644 22.3357 4.72881 22.3002 4.84434ZM22.1128 4.78662L19.368 13.6976ZM18.2642 13.3583L20.7799 5.19416H4.83869L7.16866 13.3401C7.22618 13.5409 7.34767 13.7176 7.51472 13.8433C7.68178 13.9691 7.8853 14.037 8.09448 14.0369H17.3441C17.55 14.0369 17.7504 13.9711 17.916 13.8489C18.0816 13.7268 18.2036 13.5548 18.2642 13.3583ZM9.24622 18.4583C9.24622 18.7633 9.15567 19.0614 8.98604 19.3149C8.81642 19.5685 8.57535 19.766 8.29335 19.8827C8.01136 19.9993 7.70107 20.0299 7.40173 19.9704C7.10238 19.9109 6.82737 19.7641 6.6115 19.5485C6.39563 19.3329 6.24859 19.0582 6.18902 18.7591C6.12944 18.46 6.16002 18.15 6.27687 17.8682C6.39372 17.5865 6.59158 17.3457 6.8454 17.1763C7.09921 17.007 7.39758 16.9166 7.70279 16.9166C8.11205 16.9166 8.50461 17.0789 8.79407 17.368C9.08355 17.6571 9.24622 18.0493 9.24622 18.4583ZM16.8543 17.1763C17.1082 17.007 17.4065 16.9166 17.7117 16.9166C18.121 16.9166 18.5136 17.0789 18.803 17.368C19.0925 17.6571 19.2552 18.0493 19.2552 18.4583C19.2552 18.7633 19.1646 19.0614 18.995 19.3149C18.8254 19.5685 18.5843 19.766 18.3023 19.8827C18.0203 19.9993 17.71 20.0299 17.4107 19.9704C17.1113 19.9109 16.8363 19.7641 16.6205 19.5485C16.4046 19.3329 16.2575 19.0582 16.198 18.7591C16.1384 18.46 16.169 18.15 16.2858 17.8682C16.4027 17.5865 16.6005 17.3457 16.8543 17.1763ZM8.82308 19.2059C8.97113 18.9846 9.05015 18.7244 9.05015 18.4583C9.05015 18.1014 8.90819 17.7591 8.65552 17.5068C8.40284 17.2544 8.06013 17.1126 7.70279 17.1126C7.43631 17.1126 7.17581 17.1916 6.95424 17.3394C6.73266 17.4873 6.55997 17.6974 6.45799 17.9433C6.35601 18.1892 6.32933 18.4598 6.38132 18.7208C6.43331 18.9818 6.56163 19.2216 6.75006 19.4098C6.93849 19.598 7.17857 19.7261 7.43993 19.7781C7.70129 19.83 7.9722 19.8033 8.2184 19.7015C8.4646 19.5996 8.67503 19.4272 8.82308 19.2059ZM16.9632 17.3394C17.1848 17.1916 17.4453 17.1126 17.7117 17.1126C18.0691 17.1126 18.4118 17.2544 18.6645 17.5068C18.9171 17.7591 19.0591 18.1014 19.0591 18.4583C19.0591 18.7244 18.9801 18.9846 18.832 19.2059C18.684 19.4272 18.4735 19.5996 18.2273 19.7015C17.9812 19.8033 17.7102 19.83 17.4489 19.7781C17.1875 19.7261 16.9474 19.598 16.759 19.4098C16.5706 19.2216 16.4423 18.9818 16.3903 18.7208C16.3383 18.4598 16.365 18.1892 16.4669 17.9433C16.5689 17.6974 16.7416 17.4873 16.9632 17.3394ZM4.50859 4.04075H21.5613ZM21.5613 4.04075C21.6516 4.04084 21.7406 4.06207 21.8212 4.10273ZM21.8212 4.10273C21.9017 4.1434 21.9716 4.20236 22.0253 4.27489ZM22.0253 4.27489C22.0789 4.34742 22.1147 4.43149 22.1299 4.52036ZM22.1299 4.52036C22.1451 4.60923 22.1393 4.70043 22.1128 4.78662Z" fill="#2040AF"/>
                  </svg>
                  <span v-if='count_product_in_cart > 0' class='badge'>{{ count_product_in_cart }}</span>
               </div>
               <div class='btn-badge ml10'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15.682 0H3.40409C2.59001 0 1.80928 0.334446 1.23364 0.929764C0.658003 1.52508 0.334614 2.33251 0.334614 3.17441V9.52324C0.334614 9.94011 0.414007 10.3529 0.568262 10.738C0.722519 11.1232 0.948614 11.4731 1.23364 11.7679C1.51867 12.0627 1.85704 12.2965 2.22945 12.456C2.60186 12.6155 3.001 12.6977 3.40409 12.6977H5.24577H9.79719H15.682C16.4961 12.6977 17.2768 12.3632 17.8524 11.7679C18.4281 11.1726 18.7515 10.3652 18.7515 9.52324V3.17441C18.7515 2.33251 18.4281 1.52508 17.8524 0.929764C17.2768 0.334446 16.4961 0 15.682 0ZM15.682 1.26977H3.40409C2.91564 1.26977 2.4472 1.47043 2.10182 1.82762C1.75644 2.18482 1.5624 2.66927 1.5624 3.17441V9.52324C1.5624 10.0284 1.75644 10.5128 2.10182 10.87C2.4472 11.2272 2.91564 11.4279 3.40409 11.4279H15.682C16.1704 11.4279 16.6389 11.2272 16.9843 10.87C17.3296 10.5128 17.5237 10.0284 17.5237 9.52324V3.17441C17.5237 2.66927 17.3296 2.18482 16.9843 1.82762C16.6389 1.47043 16.1704 1.26977 15.682 1.26977Z" fill="#2040AF"/>
                  <path d="M3.40409 1.26977H15.682C16.1704 1.26977 16.6389 1.47043 16.9843 1.82762C17.3296 2.18482 17.5237 2.66927 17.5237 3.17441V9.52324C17.5237 10.0284 17.3296 10.5128 16.9843 10.87C16.6389 11.2272 16.1704 11.4279 15.682 11.4279H3.40409C2.91564 11.4279 2.4472 11.2272 2.10182 10.87C1.75644 10.5128 1.5624 10.0284 1.5624 9.52324V3.17441C1.5624 2.66927 1.75644 2.18482 2.10182 1.82762C2.4472 1.47043 2.91564 1.26977 3.40409 1.26977Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0578 4.76165H6.77992C6.29148 4.76165 5.82304 4.96232 5.47766 5.31951C5.13227 5.6767 4.93824 6.16115 4.93824 6.6663V13.0151C4.93824 13.5203 5.13227 14.0047 5.47766 14.3619C5.82304 14.7191 6.29148 14.9198 6.77992 14.9198H12.9189C12.9995 14.9196 13.0795 14.9359 13.154 14.9677C13.2286 14.9995 13.2964 15.0462 13.3535 15.1052L15.9883 17.8313V15.5547C15.9883 15.3863 16.053 15.2248 16.1682 15.1057C16.2833 14.9867 16.4394 14.9198 16.6022 14.9198H19.0578C19.5463 14.9198 20.0147 14.7191 20.3601 14.3619C20.7055 14.0047 20.8995 13.5203 20.8995 13.0151V6.6663C20.8995 6.16115 20.7055 5.6767 20.3601 5.31951C20.0147 4.96232 19.5463 4.76165 19.0578 4.76165ZM6.77992 3.49188H19.0578C19.8719 3.49188 20.6526 3.82633 21.2283 4.42165C21.8039 5.01696 22.1273 5.82439 22.1273 6.6663V13.0151C22.1273 13.432 22.0479 13.8448 21.8937 14.2299C21.7394 14.6151 21.5133 14.965 21.2283 15.2598C20.9432 15.5545 20.6049 15.7884 20.2325 15.9479C19.8601 16.1074 19.4609 16.1895 19.0578 16.1895H17.2161V19.364C17.2164 19.4897 17.1805 19.6127 17.113 19.7173C17.0456 19.8219 16.9496 19.9034 16.8373 19.9516C16.725 19.9997 16.6014 20.0123 16.4822 19.9877C16.363 19.9631 16.2535 19.9025 16.1676 19.8135L12.6647 16.1895H6.77992C5.96585 16.1895 5.18512 15.8551 4.60948 15.2598C4.03384 14.6645 3.71045 13.857 3.71045 13.0151V6.6663C3.71045 5.82439 4.03384 5.01696 4.60948 4.42165C5.18512 3.82633 5.96585 3.49188 6.77992 3.49188Z" fill="#2040AF"/>
                  <path d="M19.0578 4.76165H6.77992C6.29148 4.76165 5.82304 4.96232 5.47766 5.31951C5.13227 5.6767 4.93824 6.16115 4.93824 6.6663V13.0151C4.93824 13.5203 5.13227 14.0047 5.47766 14.3619C5.82304 14.7191 6.29148 14.9198 6.77992 14.9198H12.9189C12.9995 14.9196 13.0795 14.9359 13.154 14.9677C13.2286 14.9995 13.2964 15.0462 13.3535 15.1052L15.9883 17.8313V15.5547C15.9883 15.3863 16.053 15.2248 16.1682 15.1057C16.2833 14.9867 16.4394 14.9198 16.6022 14.9198H19.0578C19.5463 14.9198 20.0147 14.7191 20.3601 14.3619C20.7055 14.0047 20.8995 13.5203 20.8995 13.0151V6.6663C20.8995 6.16115 20.7055 5.6767 20.3601 5.31951C20.0147 4.96232 19.5463 4.76165 19.0578 4.76165Z" fill="white"/>
                  <path d="M10.4639 9.32349C10.4639 9.70494 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.70494 9.08252 9.32349C9.08252 8.94204 9.39174 8.63282 9.77319 8.63282C10.1546 8.63282 10.4639 8.94204 10.4639 9.32349Z" fill="#2040AF"/>
                  <path d="M13.5947 9.30974C13.5947 9.69118 13.2855 10.0004 12.904 10.0004C12.5226 10.0004 12.2133 9.69118 12.2133 9.30974C12.2133 8.92829 12.5226 8.61906 12.904 8.61906C13.2855 8.61906 13.5947 8.92829 13.5947 9.30974Z" fill="#2040AF"/>
                  <path d="M16.7027 9.3235C16.7027 9.70494 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70494 15.3214 9.3235C15.3214 8.94205 15.6306 8.63282 16.012 8.63282C16.3935 8.63282 16.7027 8.94205 16.7027 9.3235Z" fill="#2040AF"/>
                  </svg>
                  <span class='badge'>8</span>
               </div>
               <div class='btn-badge ml10'>
                  <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2040AF" stroke-width="1.4"/>
                  <path d="M7.6748 18.5932C7.72875 18.9831 7.92197 19.3404 8.21878 19.599C8.5156 19.8575 8.89595 20 9.2896 20C9.68325 20 10.0636 19.8575 10.3604 19.599C10.6572 19.3404 10.8505 18.9831 10.9044 18.5932H7.6748Z" fill="#2040AF"/>
                  </svg>

                  <span class='badge'>8</span>
               </div>
            </div>
         </div>

         <div class='inner'> 

            <div class='input-search'>
               <input type="text" v-model='inputSearch' placeholder='Search by product or store name'>
               <span class='icon-search'>
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M4.90688 0.60506C5.87126 0.205599 6.90488 0 7.94872 0C8.99256 0 10.0262 0.205599 10.9906 0.60506C11.9549 1.00452 12.8312 1.59002 13.5693 2.32813C14.3074 3.06623 14.8929 3.94249 15.2924 4.90688C15.6918 5.87126 15.8974 6.90488 15.8974 7.94872C15.8974 8.99256 15.6918 10.0262 15.2924 10.9906C14.9914 11.7172 14.5848 12.3938 14.0869 12.999L19.7747 18.6868C20.0751 18.9872 20.0751 19.4743 19.7747 19.7747C19.4743 20.0751 18.9872 20.0751 18.6868 19.7747L12.999 14.0869C12.3938 14.5848 11.7172 14.9914 10.9906 15.2924C10.0262 15.6918 8.99256 15.8974 7.94872 15.8974C6.90488 15.8974 5.87126 15.6918 4.90688 15.2924C3.94249 14.8929 3.06623 14.3074 2.32813 13.5693C1.59002 12.8312 1.00452 11.9549 0.60506 10.9906C0.2056 10.0262 0 8.99256 0 7.94872C0 6.90488 0.2056 5.87126 0.60506 4.90688C1.00452 3.94249 1.59002 3.06623 2.32813 2.32813C3.06623 1.59002 3.94249 1.00452 4.90688 0.60506ZM7.94872 1.53846C7.10691 1.53846 6.27335 1.70427 5.49562 2.02641C4.71789 2.34856 4.01123 2.82073 3.41598 3.41598C2.82073 4.01123 2.34856 4.71789 2.02641 5.49562C1.70427 6.27335 1.53846 7.10691 1.53846 7.94872C1.53846 8.79053 1.70427 9.62409 2.02641 10.4018C2.34856 11.1795 2.82073 11.8862 3.41598 12.4815C4.01123 13.0767 4.71789 13.5489 5.49562 13.871C6.27335 14.1932 7.10691 14.359 7.94872 14.359C8.79053 14.359 9.62409 14.1932 10.4018 13.871C11.1795 13.5489 11.8862 13.0767 12.4815 12.4815C13.0767 11.8862 13.5489 11.1795 13.871 10.4018C14.1932 9.62409 14.359 8.79053 14.359 7.94872C14.359 7.10691 14.1932 6.27335 13.871 5.49562C13.5489 4.71789 13.0767 4.01123 12.4815 3.41598C11.8862 2.82073 11.1795 2.34856 10.4018 2.02641C9.62409 1.70427 8.79053 1.53846 7.94872 1.53846Z" fill="#252831"/>
                  </svg>
               </span>
            </div>
         </div>

         <div class='sliders'>
            <ul>
               <li><img src="<?php echo THEME_URI . '/assets/images/demo-home-slide01.png' ?>" alt=""></li>
            </ul>
         </div>

         <div class='inner'>
            <div class='gr-btn'>
               <button @click='gotoPage("water", {back: "home"} )' class='btn-outline'>Water</button>
               <button @click='gotoPage("ice", {back: "home"} )' class='btn-outline'>Ice</button>
            </div>

            <div class='home-contents mt40'>
               <product-recommend></product-recommend>
               <store-nearby></store-nearby>
            </div>

         </div>
      </div>

      <!-- INCLUDE PAGE LIST PRODUCT -->
      <page-water></page-water>
      <page-ice></page-ice>

      <!-- INCLUDE PAGE DETAILTS -->
      <?php //get_template_part('pages/product/product-details'); ?>

      <product-detail ref='ref_product_detail'></product-detail>

      <page-store-detail ref='ref_store_detail'></page-store-detail>

      <!-- INCLUDE PAGE PRODUCT ORDER -->
      <?php //get_template_part('pages/product/product-order'); ?>

      <page-order ref='ref_page_order'></page-order>

      <page-cart ref='ref_page_cart'></page-cart>
      
      <delivery-address ref='page_delivery_address'></delivery-address>

   </div>

   <div v-if='loading == true'>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>


</div>

<script src='<?php echo THEME_URI . '/pages/module/delivery_address.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/product_recommend.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/store_nearby.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/page_water.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/page_ice.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/product_detail.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/page_order.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/page_cart.js'; ?>'></script>
<script src='<?php echo THEME_URI . '/pages/module/store_detail.js'; ?>'></script>
<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {
         
         navigatorHistory: [],
         loading: false,
         inputSearch: '',

         delivery_address: [],
         delivery_address_primary: null,
         
         // products: [],
         productRecommend: [],
         stores: [],
         reviews: [
            /*
            {
               store_id: id,
               reviews: [
                  
               ]
            }

            */
         ],
         carts: [],


         /*
            home | water | ice | product-details ( form {water-ice}) | order | chat
            delivery_address
         */
         navigator: 'home',

      }
   },

   methods: {
      // FUNCTION REQUEST AJAX
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

      async gotoPage( page, transport){ 
         // save to history
         this.navigatorHistory.push({ to: page, transport: transport });
         window.scrollTo(0, 0);
         
         // special navigator
         if( page == 'product-detail'){
            var _product_id = transport.product_id;
            await this.$refs.ref_product_detail.findProduct(_product_id);
            this.navigator = page;
         }else if( page == 'store-detail'){
            var _store_id = transport.store_id;
            await this.$refs.ref_store_detail.findStore(_store_id);
            this.navigator = page;
         }else{
            this.navigator = page;
         }


         console.log('EXPLODE HISTORY NAVIGATOR ');
         console.log( this.navigatorHistory);
      },

      // THIS FUNCTION HELPER AUTOMATIC BACK NAVIGATOR
      goBack(){
         if( this.navigatorHistory.length > 0 ){
            var last = this.navigatorHistory.length - 1;
            var back = this.navigatorHistory[last].transport.back;
            this.navigator = back;
            this.navigatorHistory.pop();
         }
      },

      


      // async gotoProductDetails( product ){
      //    this.canOrder = true;

      //    // OUT OF STOCK
      //    if( this.product_details.mark_out_of_stock == 1){
      //       this.modal_store_out_of_stock = true;
      //       this.canOrder = false; 
      //    }
         
      //    // GET STORE
      //    var form = new FormData();
      //    form.append('action', 'atlantis_get_store');
      //    form.append('store_id', product.store_id );
      //    var r = await this.request(form);
      //    if( r != undefined ){
      //       var res = JSON.parse( JSON.stringify(r ) );
      //       if( res.message == 'store_found' ){
      //          var _data = res.data[0];
      //          _data.store_working = false;

      //          /**
      //           * @access CHECK STORE TIME WORKING
      //           */
      //          if( _data.start_time != null && _data.close_time != null ){
      //             // convert timestamp to date
      //             var _startTime = new Date(_data.start_time * 1000);
      //             var _closeTime = new Date(_data.close_time * 1000);
      //             var _startTimeString = _startTime.getDate() + '/' + _startTime.getMonth() + '/' + _startTime.getFullYear();
      //             var _closeTimeString = _closeTime.getDate() + '/' + _closeTime.getMonth() + '/' + _closeTime.getFullYear();

      //             _data.start_time = _startTimeString;
      //             _data.close_time = _closeTimeString;
      //             _data.store_working = this.check_store_time_working(_startTime, _closeTime);
      //             if( _data.store_working == false ){
      //                // OPEN MODAL
      //                this.modal_store_working = true;
      //                this.canOrder = false; 
      //             }
      //          }

      //          /**
      //           * @access CHECK OUT OF STOCK
      //           */
               
      //          this.product_details.store = _data;
      //       }
   },

   computed: {
      count_product_in_cart(){
         var _totalItem = 0;
         if( this.carts.length > 0 ){
            this.carts.forEach((item) => _totalItem += item.products.length );
         }
         return _totalItem;
      },

      count_product_select(){
         var _checkout = [];
         this.$root.carts.forEach( store => {
            store.products.forEach( product => {
               if( product.product_select == true ){
                  _checkout.push( product.product_id);
               }else if( _checkout > 0 ){
                  _checkout.pop();
               }
            });
         });
         return _checkout.length;
      },

      // GROUP
      count_product_total_price(){
         var gr_price = {
            price: 0,
            price_discount: 0
         };
         this.$root.carts.forEach( store => {
            store.products.forEach(product => {
               if( product.product_discount_percent != null || product.product_discount_percent != 0 ){
                  gr_price.price_discount += ( product.product_price - ( product.product_price * ( product.product_discount_percent / 100)) ) * product.product_quantity_count;
               }else{
                  gr_price.price_discount += product.product_price * product.product_quantity_count;
               }
               gr_price.price += product.product_price * product.product_quantity_count;
            });

         });
         
         var _final_price = null;

         if( gr_price.price != gr_price.price_discount){
            _final_price = gr_price.price.toLocaleString('vi-VN') + ' đ'
         }

         return {
            price: _final_price,
            price_discount: gr_price.price_discount.toLocaleString('vi-VN') + ' đ'
         };
      },


      hasDeliveryAddressPrimary(){
         if(this.delivery_address.length > 0){
            var lookup = this.delivery_address.find((s) => s.primary == 1);
            if( lookup != undefined ){
               this.delivery_address_primary = lookup;
               return true;
            }
            return false;
         }
         return false;
      },

   },

   
   async created(){
   },

   async mounted(){
   },

})
.component('delivery-address', PageDeliveryAddress)
.component('product-recommend', ProductRecommend)
.component('store-nearby', StoreNearby)
.component('page-water', PageWater)
.component('page-ice', PageIce)
.component('product-detail', PageProductDetail)
.component('page-order', PageOrder)
.component('page-cart', PageCart)
.component('page-store-detail', PageStoreDetail)
.mount('#app');
</script>
