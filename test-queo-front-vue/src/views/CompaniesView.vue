<template>
  <content-header title="Empresas" icon="fa fa-building" />
  <content>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Empresas</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-12 mb-3">
              <button class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#create">
                Crear Empresa
              </button>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="companiesTable" class="table table-striped table-bordered table-hover display">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Logo</th>
                      <th>WebSite</th>
                      <th>Numero de empleados</th>
                      <th>Fecha de creacion</th>
                      <th>Fecha de actualizacion</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item,id in data" :key="id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.name }}</td>
                      <td>{{ item.email }}</td>
                      <td>{{ item.logo }}</td>
                      <td>{{ item.website }}</td>
                      <td>{{ item.employees_num }}</td>
                      <td>{{ item.created_at }}</td>
                      <td>{{ item.updated_at }}</td>
                      <td>
                        <button  type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#edit" @click="editCompany(item.id)"><i class="fa fa-pen"></i></button>
                        <button  type="button" :data-id="item.id" class="btn btn-outline-danger" id="delete" @click="deleteCompany"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12">
              <ModalSaveView
              :modalId="modalId"
              />
            </div>
            <div class="col-md-12">
              <ModalEditView
              :modalId="modalId"
              :dataCompany="dataCompany"
              />
            </div>
          </div>
          <div class="card-footer">Footer</div>
        </div>
      </div>
    </div>
  </content>
</template>
<script>
import axiosServices from "../services/axiosServices.js";
import DataTable from "datatables.net-bs5";
import $ from "jquery";
import DataTablesLib from "datatables.net-bs5";
import ButtonsHtml5 from "datatables.net-buttons/js/buttons.html5";
import pdfmake from "pdfmake";
import "datatables.net-responsive-bs5";
import ModalSaveView from "../components/ModalCompany.vue"
import ModalEditView from "../components/ModalEditCompany.vue"

DataTable.use(DataTablesLib);
DataTable.use(pdfmake);
DataTable.use(ButtonsHtml5);

export default {
  components: {
    DataTable,
    ModalSaveView,
    ModalEditView
  },
  data() {
    return {
      dataCompany:null,
      fields: {
        name: "",
        email: "",
        logo: null,
        website :"",
      },
      modalId: 0,
      data: null,
    };
  },
  mounted() {
    this.getCompanies();
  },
  methods: {
    table(){
      this.$nextTick(() => {
        $("#companiesTable").DataTable({
          responsive: true,
          authWith: false,
          dom: 'Bfrtip',
          languaje: {
            search: 'Buscar',
            zeroRecords: 'No hay registros para mostrar',
            info: 'MOstrando del _START_ a _END_ de _TOTAL_ registros',
            infoFiltered: '(Filtrados de _MAX_ registros.)',
            paginate: {
              first: 'Primero',
              previus: 'Anterior',
              next: 'Siguiente',
              last: 'Ültimo',
            },
          },
        });
      })
    },
    getCompanies() {
      axiosServices.onAxiosGet("companies").then((response) => {
        if (response.status == "Success") {
          this.data = response.data;
          this.table();
        } else {
          if (response.status == "Error") {
            this.$swal({
              heightAuto: false,
              icon: "error",
              html: `${JSON.stringify(response.errors)})}`,
              title: "Error",
            });
          }
        }
      });
    },
    editCompany(id){
      this.dataCompany = this.data.filter((value) => value.id == id ? value : '');
    },
    deleteCompany(event){
      new Swal({
          title: "¿Estas Seguro?",
          text: "Una vez eliminado, ¡no podrá recuperar este registro!",
          icon: "warning",
          showCancelButton: true,
          showConfirmButton: true,
          confirmButtonText: 'Eliminar',
          denyButtonText: `Cancelar`,
      })
      .then((result) => {
        if (result.isConfirmed) {
          axiosServices.onAxiosDelete(`companies/${event.target.dataset.id}`).then((response) => {
            if (response.status == "Success") {
              new Swal('Eliminado', '', 'success');
              window.location.reload();
            } else {
              if (response.status == "Error") {
                new Swal({
                  heightAuto: false,
                  icon: "error",
                  html: `${JSON.stringify(response.errors)})}`,
                  title: "Error",
                });
              }
            }
          });
          
        } else if (result.isDenied) {
          new Swal('Changes are not saved', '', 'info')
        }
      });
    }
  },
};
</script>

<style>
@import "datatables.net-bs5";
</style>
