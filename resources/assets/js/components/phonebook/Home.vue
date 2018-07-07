<template>
  <div>
      <nav class="panel column is-offset-2 is-8">
        <p class="panel-heading">
            Vue-Lara Phonebook
            <button class="button is-link is-outlined " @click="openAdd">
                Add New
            </button>
            <span class="is-pulled-right" v-if="loading">
                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
            </span>
        </p>
        <div class="panel-block">
            <p class="control has-icons-left">
            <input class="input is-small" type="text" placeholder="search" v-model="searchQuery">
            <span class="icon is-small is-left">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
            </p>
        </div>

        <a class="panel-block" v-for="(item,index) in temp" :key="index" >
            <span class="column is-9">
                {{ item.name }}
            </span>
            
            <span class="panel-icon column is-1">
                <i class="has-text-danger fa fa-trash" aria-hidden="true" @click="openDelete(index, item.id)"></i>
            </span>
            <span class="panel-icon column is-1">
                <i class="has-text-info fa fa-edit" aria-hidden="true" @click="openEdit(index)"></i>
            </span>
            <span class="panel-icon column is-1">
                <i class="has-text-primary fa fa-eye" aria-hidden="true" @click="openShow(index)"></i>
            </span>
        </a>
    </nav>
        <Add :openModal='addActive' @closeModal="close"></Add>
        <Show :openModal='showActive' @closeModal="close"></Show>
        <Update :openModal='updateActive' @closeModal="close"></Update>

  </div>
</template>

<script>
    import Add from './Add.vue'
    import Show from './Show.vue'
    import Update from './Update.vue'
    export default {
        data () {
            return {
                addActive: '',
                showActive: '',
                updateActive: '',
                lists: {},
                errors: {},
                loading: false,
                searchQuery: '',
                temp: ''
            }
        },
        watch: {
            searchQuery () {
                if(this.searchQuery.length > 0){
                    this.temp = this.lists.filter((item) => {
                        return Object.keys(item).some((key)=>{
							let string = String(item[key]) 
							return string.toLowerCase().indexOf(this.searchQuery.toLowerCase())>-1
							// console.log(string)
						})
                    })
                }else{
                    this.temp = this.lists;
                }
            }
        },
        mounted () {
                axios.post(`/getData`)
                    .then(response => this.temp = this.lists = response.data)
                    .catch(e =>  this.errors = error.response.data.errors)
        },
        components: {
            Add,
            Show,
            Update
        },
        methods: {
            openShow (index) {
                this.$children[1].list = this.lists[index]
                this.showActive = 'is-active'
            },
            openEdit (index) {
                this.$children[2].list = this.lists[index]
                this.updateActive = 'is-active'
            },
            openAdd () {
                this.addActive = 'is-active'
            },
            openDelete (index, id) {
                 if(confirm('Are You Sure?')){
                    this.loading = !this.loading;
                    axios.delete(`/phonebook/${id}`)
                    .then(response => { 
                        this.lists.splice(index,1);
                        this.loading = !this.loading;
                    })
                    .catch(e =>  this.errors = error.response.data.errors)
                }
            },
            close () {
                this.addActive = '',
                this.showActive = '',
                this.updateActive= ''
            }
        }
    }
</script>