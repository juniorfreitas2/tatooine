
<template>
  <div>
    <div class="row">
      <data-grid-filter :filters="userFilters"></data-grid-filter>
    </div>
    <vuetable
      ref="vuetable"
      class="table-bordered table-striped"
      :css="css"
      :api-url="url"
      :fields="fields"
      :append-params="filters"
      pagination-path=""
      @vuetable:pagination-data="onPaginationData"
    >
      <template slot="actions" slot-scope="props">
        <data-grid-actions 
          :actions="actions" 
          :primary-key="props.rowData[primaryKey]"
          @delete="refreshDataGrid"
        >
        </data-grid-actions>
      </template>
    </vuetable>
    
    <pagination-info 
      ref="paginationInfo"
      :css="css.pagination"
      info-class="pull-left"
      info-template="Exibindo de {from} até {to} de {total} itens"
    >
    </pagination-info>
    
    <pagination 
      ref="pagination" 
      @vuetable-pagination:change-page="onChangePage"
      :css="css.pagination"
    >
    </pagination>
  </div>
</template>


<script>
import axios from 'axios'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import DataGridActions from './DataGridActions'
import DataGridFilter from './DataGridFilter'

export default {
  components: {
    vuetable: Vuetable,
    pagination: VuetablePagination,
    paginationInfo: VuetablePaginationInfo,
    dataGridActions: DataGridActions,
    dataGridFilter: DataGridFilter
  },
  props: ['url', 'userFields', 'userFilters', 'dataCss', 'titleCss', 'actions', 'primaryKey'],
  data () {
    return {
      fields: [],
      filters: {},
      css: {
        tableClass: 'table table-striped table-bordered',
        loadingClass: 'loading',
        ascendingIcon: 'glyphicon glyphicon-chevron-up',
        descendingIcon: 'glyphicon glyphicon-chevron-down',
        handleIcon: 'glyphicon glyphicon-menu-hamburger',
        pagination: {
          infoClass: 'pull-left',
          wrapperClass: 'vuetable-pagination pull-right',
          activeClass: 'btn-primary',
          disabledClass: 'disabled',
          pageClass: 'btn btn-border',
          linkClass: 'btn btn-border',
          icons: {
            first: '',
            prev: '',
            next: '',
            last: '',
          },
        }
      }
    }
  },
  methods: {
    assocUserFields () {
      const userFields = this.userFields

      for (let field in userFields) {
        
        this.fields.push({
          name: field,
          title: userFields[field],
          dataClass: this.getDataClass(field),
          titleClass: this.getFieldClass(field)
        })

      }

      this.fields.push({
        name: '__slot:actions',
        title: '#',
        dataClass: 'data-grid-actions'
      })
    },

    getDataClass (field) {
      if (this.dataCss) {
        return dataCss[field]
      }

      return ''
    },

    getFieldClass (field) {
      if (this.titleCss) {
        return this.titleCss[field]
      }

      return ''
    },

    assocUserFilters () {
      Object.keys(this.userFilters).map(filter => this.$set(this.filters, filter, '') )
    },

    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },

    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },

    refreshDataGrid () {
      this.$refs.vuetable.refresh();
      toastr.success('Your register was deleted with success', 'All done!')
    }
  },
  created () {
    this.assocUserFields()
    this.assocUserFilters()
  }
}
</script>