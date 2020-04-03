<template>
    <footer>
        <form :action="path"  method="post" class="text-right">
            <button
                type="submit"
                class="text-xs"
                @click.prevent="$modal.show(modalName)">
                Delete
            </button>
        </form>

        <modal :name="modalName" classes="p-4 bg-card rounded-lg" height="auto">
            <h1 class="font-normal mb-8 text-center text-2xl">Delete project</h1>

            <div class="mb-8">
                <p class="mb-4">
                    Deleting the project is irreversible.
                    To confirm your choice, please enter the name of the project in the field below.
                </p>
                <input
                    type="text"
                    name="confirm"
                    :class="form.errors.confirm ? 'input-error' : 'input'"
                    v-model="form.confirm"
                    :placeholder="title"
                    @keyup.enter="submit"
                >

                <span class="text-xs italic text-error" v-if="form.errors.confirm" v-text="form.errors.confirm[0]"></span>
            </div>

            <footer class="text-right">
                <button class="mr-4" @click="reset">Cancel</button>
                <button class="button-error" @click="submit">Delete project</button>
            </footer>
        </modal>
    </footer>
</template>

<script>
    import ProjectBoardForm from '../ProjectBoardForm';

    export default {
        props: [
            'id',
            'path',
            'title'
        ],

        data () {
            return {
                form: new ProjectBoardForm({
                    confirm: ''
                })
            }
        },

        methods: {
            async submit() {
                if (this.title.toLowerCase() != this.form.confirm.toLowerCase()) {
                    this.form.errors = {
                        "confirm": ['The project\'s name is not correct']
                    };
                } else {
                    await this.form.delete(this.path);
                    location = "/projects";
                }
            },

            reset() {
                this.$modal.hide(this.modalName);
                this.form.reset();
            }
        },

        computed: {
            modalName () {
                return "delete-project" + this.id;
            }
        }
    }
</script>
