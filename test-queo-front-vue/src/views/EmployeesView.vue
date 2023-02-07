<template>
  <content-header title="Empleados" icon="fa fa-users" />
  <content>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Listado de Empleados</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-12 mb-3">
              <button class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#create">
                Crear Empleado
              </button>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="employeesTable" class="table table-striped table-bordered table-hover display">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Empresa</th>
                      <th>Correo</th>
                      <th>Telefono</th>
                      <th>Fecha de creacion</th>
                      <th>Fecha de actualizacion</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item,id in data" :key="id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.first_name }}</td>
                      <td>{{ item.last_name }}</td>
                      <td>{{ item.company_name }}</td>
                      <td>{{ item.email }}</td>
                      <td>{{ item.phone }}</td>
                      <td>{{ item.created_at }}</td>
                      <td>{{ item.updated_at }}</td>
                      <td>
                        <button  type="button" :data-id="item.id" class="btn btn-outline-info" data-toggle="modal" data-target="#editemployee" @click="editEmployee(item.id)"><i class="fa fa-pen"></i></button>
                        <button  type="button" :data-id="item.id" class="btn btn-outline-danger" id="delete" @click="deleteEmployee"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12">
              <ModalView
              :selectData="selectData"
              :modalId="modalId"
              />
            </div>
            <div class="col-md-12">
              <ModalEditView
              :modalId="modalId"
              :selectData="selectData"
              :dataEmployee="dataEmployee"
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

import ModalView from "../components/ModalEmployee.vue"
import ModalEditView from "../components/ModalEditEmployee.vue"

DataTable.use(DataTablesLib);
DataTable.use(pdfmake);
DataTable.use(ButtonsHtml5);

export default {
  components: {
    DataTable,
    ModalView,
    ModalEditView
  },
  data() {
    return {
      data: null,
      selectData: null,
      dataEmployee:null,
      fields: {
        first_name: "",
        last_name: "",
        company_id: "",
        email: "",
        phone: "",
      },
      modalId: 0,
    };
  },
  mounted() {
    this.getEmployees();
    this.getCompanies();
  },
  methods: {
    table(){
      this.$nextTick(() => {
        $("#employeesTable").DataTable({
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
    getEmployees() {
      axiosServices.onAxiosGet("employees").then((response) => {
        if (response.status == "Success") {
          this.data = response.data;
           this.table();
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
    },
    deleteEmployee(event){
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
           axiosServices.onAxiosDelete(`employees/${event.target.dataset.id}`).then((response) => {
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
    },
    editEmployee(id){
      this.dataEmployee = this.data.filter((value) => value.id == id ? value : '');
    },
    getCompanies() {
      axiosServices.onAxiosGet("companies").then((response) => {
        if (response.status == "Success") {
          this.selectData = response.data;
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
    }
  },
};
</script>

<style>
@import "datatables.net-bs5";
</style>
