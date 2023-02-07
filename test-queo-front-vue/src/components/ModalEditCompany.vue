<template>
  <Teleport to="body">
    <focus-trap v-model:active="active">
      <div
        id="edit"
        tabindex="-1"
        aria-labelledby="editLabel"
        aria-hidden="true"
        ref="modal"
        class="modal fade"
        :class="{ show: active, 'd-block': active }"
        role="dialog"
        :aria-labelledby="`modal-${modalId}`"
        :aria-hidden="active"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createLabel">Editar</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="update()">
                <div class="input-group mb-3">
                  <input
                    v-model="fields.name"
                    type="text"
                    class="form-control"
                    placeholder="Nombre"
                  />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input
                    v-model="fields.email"
                    type="emai"
                    class="form-control"
                    placeholder="Correo"
                  />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input
                    v-model="fields.website"
                    type="text"
                    class="form-control"
                    placeholder="Pagina Web"
                  />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-link"></span>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                @click="$emit('closeModal', true)"
              >
                Cerrar
              </button>
              <button type="button" class="btn btn-primary" @click="update">
                Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </focus-trap>
  </Teleport>
</template>

<script>
import axiosServices from "../services/axiosServices.js";
import { ref, watch } from "vue";
import { FocusTrap } from "focus-trap-vue";

export default {
  name: "Modal",
  components: {
    FocusTrap: FocusTrap,
  },
  emits: ["closeModal"],
  props: {
    showModal: Boolean,
    modalId: Number,
    dataCompany: Array
  },
  data() {
    return {
      fields: {
        id: "",
        name: "",
        email: "",
        logo: null,
        website: "",
      },
    };
  },
  setup(props) {
    const id = 1;
    const active = ref(props.showModal);  
    return {
      active,
      id,
    };
  },
  methods: {
    selectFile(event) {
      this.fields.logo = event.target.files[0];
    },
    update() {
      let body = {
        id: this.fields.id,
        name: this.fields.name,
        email: this.fields.email,
        logo: this.fields.logo,
        website: this.fields.website,
      };

      axiosServices.onAxiosPutWithfile(`companies/${this.fields.id}`,body).then((response) => {
        if (response.status == "Success") {
          this.responseSuccess(response);
        } else {
          if (response.status == "Error") {
            new Swal({
              heightAuto: false,
              icon: "error",
              html: `${JSON.stringify(response.errors)})}`,
              title: "Error de validación",
            });
          }
        }
      });
    },
    responseSuccess(response) {
      new Swal({
        heightAuto: false,
        icon: "Success",
        html: `Se ha guardado correctamente`,
        title: "Confirmación",
      }).then(() => {
        window.location.reload();
      });
    },
  },
  watch : {
    dataCompany : {
      handler : function(value){
        this.fields.id = value[0].id
        this.fields.name = value[0].name
        this.fields.email = value[0].email
        this.fields.logo = value[0].logo
        this.fields.website = value[0].website
      },
      deep:true 
    }
  }
};
</script>
