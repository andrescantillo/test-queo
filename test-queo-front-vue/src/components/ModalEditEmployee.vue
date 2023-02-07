<template>
  <Teleport to="body">
    <focus-trap v-model:active="active">
      <div
        id="editemployee"
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
                    v-model="fields.first_name"
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
                    v-model="fields.last_name"
                    type="text"
                    class="form-control"
                    placeholder="Apellido"
                  />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <select
                    class="custom-select"
                    aria-label="Escoge la empresa"
                    placeholder="Empresa"
                    v-model="fields.company_id"
                  >
                    <option
                      v-for="(item, id) in selectData"
                      :key="id"
                      :value="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
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
                    v-model="fields.phone"
                    type="text"
                    class="form-control"
                    placeholder="Telefono"
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
    selectData: Object,
    dataEmployee: Array
  },
  data() {
    return {
      fields: {
        id:"",
        first_name: "",
        last_name: "",
        company_id: "",
        email: "",
        phone: "",
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
    update() {
      let body = {
        id: this.fields.id,
        first_name: this.fields.first_name,
        last_name: this.fields.last_name,
        company_id: this.fields.company_id,
        email: this.fields.email,
        phone: this.fields.phone,
      };

      axiosServices.onAxiosPutWithfile(`employees/${this.fields.id}`,body).then((response) => {
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
    dataEmployee : {
      handler : function(value){
        this.fields.id = value[0].id,
        this.fields.first_name = value[0].first_name,
        this.fields.last_name = value[0].last_name,
        this.fields.company_id = value[0].company_id,
        this.fields.email = value[0].email,
        this.fields.phone = value[0].phone
      },
      deep:true 
    }
  }
};
</script>
