<template>
  <div class="modal" :class="openModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Add New Contact</p>
            <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <section class="modal-card-body">
        <!-- Content ... -->
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" :class="{'is-danger':errors.name}" type="text" placeholder="Name" v-model="list.name">
                <small class="has-text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
            </div>
        </div>

        <div class="field">
            <label class="label">Phone</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input " :class="{'is-danger':errors.phone}" type="text" placeholder="Phone Number" v-model="list.phone">
                <span class="icon is-small is-left">
                    <i class="fa fa-user"></i>
                </span>
                <small class="has-text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small>
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" :class="{'is-danger':errors.email}" type="email" placeholder="Email input" v-model="list.email">
                <span class="icon is-small is-left">
                <i class="fa fa-envelope"></i>
                </span>
                <span class="icon is-small is-right">
                <i class="fa fa-exclamation-triangle"></i>
                </span>
                <small class="has-text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>
            </div>
        </div>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" @click="saveData">Save changes</button>
            <button class="button" @click="close">Cancel</button>
        </footer>
    </div>
  </div>
</template>

<script>
    export default {

        props: [
            'openModal'
        ],
        data () {
            return {
                list: {
                    name: '',
                    phone: '',
                    email: ''
                },
                errors: {}
            }
        },
        methods: {
            close () {
                this.$emit('closeModal')
            },
            saveData(){
                
                console.log(this.$data.list);
				axios.post(`/phonebook`,this.$data.list).then((response)=> {
                    console.log(response);
					this.close()
					this.$parent.lists.push(response.data)
					this.$parent.lists.sort(function(a,b){
						if (a.name > b.name) {
							return 1;
						}else if(a.name < b.name){
							return -1;
						}
					})
					this.list = ""
				})
				  .catch((error) => this.errors = error.response.data.errors)
			}
		}
    }
</script>