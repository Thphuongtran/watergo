<div class='appbar-bottom'>
  <ul class='header-filter'>
    <li
      v-for='(filter, index) in header_filter'
      @click='select_header_filter(filter.label)'
      :key='index'
      :class='filter.active == true ? "active" : ""'
    >
      {{ filter.label }}
    </li>
  </ul>
</div>
