<template>
    <modal name="new-project"
           classes="p-4 bg-card rounded-lg"
           height="auto"
           adaptive="true"
           scrollable="true"
           >
        <h1 class="font-normal mb-4 md:mb-16 text-center text-2xl">Let's start something new</h1>

        <div class="md:flex mb-2 md:mb-8">
            <div class="flex-none md:flex-1 md:mr-4">
                <div class="mb-2 md:mb-4">
                    <label for="title" class="text-sm block mb-2">Title</label>

                    <input
                        type="text"
                        :class="form.errors.title ? 'input-error' : 'input'"
                        id="title"
                        name="title"
                        v-model="form.title">

                    <span class="text-xs italic text-error" v-if="form.errors.title" v-text="form.errors.title[0]"></span>
                </div>

                <div class="mb-2 md:mb-4">
                    <label for="description" class="text-sm block mb-2">Description</label>

                    <textarea
                        class="h-16 md:h-32"
                        :class="form.errors.description ? 'input-error' : 'input'"
                        id="description"
                        name="description"
                        v-model="form.description">
                    </textarea>

                    <span class="text-xs italic text-error" v-if="form.errors.description" v-text="form.errors.description[0]"></span>
                </div>
            </div>

            <div class="hidden md:block md:flex-1 md:ml-4">
                <div class="mb-2 md:mb-4">
                    <label class="text-sm block mb-2">Let's add some tasks</label>
                    <input type="text" class="input mb-2" placeholder="New task" v-for="task in form.tasks" v-model="task.body">
                </div>

                <button type="button" class="inline-flex items-center text-xs" @click="addTask">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                        <g fill="none" fill-rule="evenodd" opacity=".307">
                            <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                            <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                        </g>
                    </svg>

                    <span>Add New Task Field</span>
                </button>
            </div>
        </div>

        <footer class="text-right">
            <button class="mr-4" @click="reset">Cancel</button>
            <button class="button" @click="submit">Create project</button>
        </footer>
    </modal>
</template>

<script>
    import ProjectBoardForm from '../ProjectBoardForm';

    export default {
        data () {
            return {
                form: new ProjectBoardForm({
                    title: '',
                    description: '',
                    tasks: [
                        { body: ''}
                    ]
                })
            }
        },

        methods: {
            addTask() {
                this.form.tasks.push({body: ''})
            },

            async submit() {
                this.form.post('/projects')
                    .then(response => location = response.data.message)
                    .catch(error => {}) ;
            },

            reset() {
                this.$modal.hide('new-project');
                this.form.reset();
            }
        }
    }
</script>
