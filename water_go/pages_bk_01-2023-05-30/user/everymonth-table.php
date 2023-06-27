<div v-show='popup_deliverySelect_monthly_date' class='date-table'>
   <div class='date-table-head'><div class='heading'>Everymonth</div></div>
   <div class='date-table-contents'>
      <table>
         <tr>
            <td :class="deliveryEverymonthOrder == 1 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 1)'><span>1</span></td>
            <td :class="deliveryEverymonthOrder == 2 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 2)'><span>2</span></td>
            <td :class="deliveryEverymonthOrder == 3 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 3)'><span>3</span></td>
            <td :class="deliveryEverymonthOrder == 4 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 4)'><span>4</span></td>
            <td :class="deliveryEverymonthOrder == 5 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 5)'><span>5</span></td>
            <td :class="deliveryEverymonthOrder == 6 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 6)'><span>6</span></td>
            <td :class="deliveryEverymonthOrder == 7 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 7)'><span>7</span></td>
         </tr>
         <tr>
            <td :class="deliveryEverymonthOrder == 8 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 8)'><span>8</span></td>
            <td :class="deliveryEverymonthOrder == 9 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 9)'><span>9</span></td>
            <td :class="deliveryEverymonthOrder == 10 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 10)'><span>10</span></td>
            <td :class="deliveryEverymonthOrder == 11 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 11)'><span>11</span></td>
            <td :class="deliveryEverymonthOrder == 12 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 12)'><span>12</span></td>
            <td :class="deliveryEverymonthOrder == 13 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 13)'><span>13</span></td>
            <td :class="deliveryEverymonthOrder == 14 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 14)'><span>14</span></td>
         </tr>
         <tr>
            <td :class="deliveryEverymonthOrder == 15 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 15)'><span>15</span></td>
            <td :class="deliveryEverymonthOrder == 16 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 16)'><span>16</span></td>
            <td :class="deliveryEverymonthOrder == 17 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 17)'><span>17</span></td>
            <td :class="deliveryEverymonthOrder == 18 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 18)'><span>18</span></td>
            <td :class="deliveryEverymonthOrder == 19 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 19)'><span>19</span></td>
            <td :class="deliveryEverymonthOrder == 20 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 20)'><span>20</span></td>
            <td :class="deliveryEverymonthOrder == 21 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 21)'><span>21</span></td>
         </tr>
         <tr>
            <td :class="deliveryEverymonthOrder == 22 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 22)'><span>22</span></td>
            <td :class="deliveryEverymonthOrder == 23 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 23)'><span>23</span></td>
            <td :class="deliveryEverymonthOrder == 24 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 24)'><span>24</span></td>
            <td :class="deliveryEverymonthOrder == 25 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 25)'><span>25</span></td>
            <td :class="deliveryEverymonthOrder == 26 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 26)'><span>26</span></td>
            <td :class="deliveryEverymonthOrder == 27 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 27)'><span>27</span></td>
            <td :class="deliveryEverymonthOrder == 28 ? 'active' : ''" @click='button_get_data_delivery("monthly", deliveryMonthlyOrder, "date", 28)'><span>28</span></td>
         </tr>
         <tr>
            <td>29</td>
            <td>30</td>
            <td>31</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
      </table>
   </div>
   <div class='btn-getdate'><button @click='apply_DeliverySelect_monthly' class='button'>Apply</button></div>
</div>