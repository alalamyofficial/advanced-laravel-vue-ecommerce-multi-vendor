<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps } from "vue";
import categoryShow from "@/Pages/admin/categories/action.vue";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

defineProps({
    categories: Array,
});
</script>

<script>
export default {
    name: "SubCategoryAction",
    data() {
        return {
            isModalOpen: false,
            modalCategory: Object,
            all_sub_categories: Array,
            all_categories: Array,
            sub_category_details: Object,
            name: "",
            desc: "",
            showModal: true,
            counterId: 1,
        };
    },
    mounted() {
        this.fetchSubCategories();
    },
    methods: {

        fetchCategories() {
            axios
                .get("/all/categories")
                .then((response) => {
                    this.all_categories = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        fetchSubCategories() {
            axios
                .get("/all/sub/categories")
                .then((response) => {
                    this.all_sub_categories = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showSubCategoryModal(id) {
            axios
                .get("/sub_categories/" + id)
                .then((response) => {
                    this.modalCategory = response.data;
                    console.log(this.modalCategory);
                    Swal.fire({
                        title: this.modalCategory.name,
                        text: this.modalCategory.desc,
                        footer:
                        `
                            <center>
                                <div class="d-flex">
                                    <div class="mt-1 ml-2">
                                        <span class="">Category : </span>
                                    </div>
                                    <div>
                                        <button type="disabled" class="btn btn-block btn-sm bg-gradient-warning">
                                            ${this.modalCategory.category.name}
                                        </button>
                                    </div>
                                </div>
                            </center>
                        `,
                        closeOnEsc: true,
                        closeOnClickOutside: true,
                        buttons: {
                            close: {
                                text: "Close",
                                value: null,
                                visible: true,
                                className: "",
                                closeModal: true,
                            },
                        },
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        generateOptions() {
            let options = "";
            if (this.all_categories && this.all_categories.length > 0) {
            for (let i = 0; i < this.all_categories.length; i++) {
                const category = this.all_categories[i];
                options += `<option value="${category}">${category.name}</option>`;
            }
            }
            return options;
        },

        storeSubCategory(e) {
            e.preventDefault();
            let name = null;
            let desc = null;
            let category_id = null;

            axios.get("/all/categories")
                .then((response) => {
                    this.all_categories = response.data;

                    Swal.fire({
                        title: "Create Category",
                        html: `
                            <div class="col-md-10 col-lg-10">
                                <input type="text" class="swal2-input form-control"
                                    name="name" id="swal-name" placeholder="Enter ..."
                                >
                                <textarea class="swal2-textarea form-control" rows="3"
                                    name="desc" id="swal-desc" placeholder="Enter ...">
                                </textarea>
                                <select class="swal2-select form-control" name="category" id="swal-category">
                                    <option value="">Select a category</option>
                                    ${this.all_categories.map(category => `
                                        <option name="category_id" value="${category.id}">${category.name}</option>`).join('')
                                    }
                                </select>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Save",
                        cancelButtonText: "Cancel",
                        preConfirm: () => {
                            // Retrieve values directly from the input elements
                            name = document.getElementById("swal-name").value;
                            desc = document.getElementById("swal-desc").value;
                            category_id = document.getElementById("swal-category").value;

                            if (!name) {
                                Swal.showValidationMessage(
                                    "Please enter a valid name."
                                );
                            }
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios
                                .post("/sub_categories", { name,desc,category_id })
                                .then((response) => {
                                    Swal.fire(
                                        "Created!",
                                        "Your category has been created.",
                                        "success"
                                    );
                                    this.fetchSubCategories();
                                })
                                .catch((error) => {
                                    Swal.fire(
                                        "Oops...",
                                        "Something went wrong while creating the category.",
                                        "error"
                                    );
                                    console.error(error);
                                });
                        }
                    });
                })


        },

        updateCategory(subCategory) {
            axios.get("/all/categories")
                .then((response) => {
                    this.all_categories = response.data;
                    axios.get("/sub_categories/" + subCategory).then((response) => {
                        this.sub_category_details = response.data;

                        let name; // Declare the name variable
                        let desc; // Declare the desc variable
                        let category_id;

                        Swal.fire({
                            title: "Update Category",
                            html: `
                                    <div class="col-md-10 col-lg-10">
                                        <input type="text" class="swal2-input form-control"
                                        name="name" id="swal-name" name="name"
                                        value="${this.sub_category_details.name}"
                                        placeholder="Enter ...">

                                        <textarea class="swal2-textarea name="desc"
                                            form-control col-md-12 col-lg-12" rows="6"
                                            name="desc" id="swal-desc" placeholder="Enter ..."
                                                style="width: 340px;">
                                                ${this.sub_category_details.desc}
                                        </textarea>

                                        <select class="swal2-select form-control" name="category" id="swal-category">
                                            <option value="">Select a category</option>
                                            ${this.all_categories.map(category => `
                                                <option name="category_id" value="${category.id}"
                                                ${category.id === this.sub_category_details.category_id
                                                        ? 'selected' : ''}>
                                                    ${category.name}
                                                </option>`).join('')}
                                        </select>



                                    </div>
                                `,
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Update",
                            cancelButtonText: "Cancel",
                            preConfirm: () => {
                                // Retrieve values directly from the input elements
                                name = document.getElementById("swal-name").value;
                                desc = document.getElementById("swal-desc").value;
                                category_id = document.getElementById("swal-category").value;


                                if (!name) {
                                    Swal.showValidationMessage(
                                        "Please enter a valid name."
                                    );
                                }
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios
                                    .put("/sub_categories/" + subCategory, { name, desc ,category_id })
                                    .then((response) => {
                                        Swal.fire(
                                            "Updated!",
                                            "Your Sub Category has been updated.",
                                            "success"
                                        );
                                        this.fetchSubCategories();
                                    })
                                    .catch((error) => {
                                        Swal.fire(
                                            "Oops...",
                                            "Something went wrong while creating the Sub Category.",
                                            "error"
                                        );
                                        console.error(error);
                                    });
                            }
                        });
                    });
            })
        },

        deleteSubCategory(subCategory) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/sub_categories/${subCategory}`)
                        .then((response) => {
                            Swal.fire(
                                "Deleted!",
                                "Your item has been deleted.",
                                "success"
                            );
                            this.fetchSubCategories();
                            // Put any additional actions here after successful deletion
                        })
                        .catch((error) => {
                            Swal.fire(
                                "Oops...",
                                "Something went wrong while deleting the item.",
                                "error"
                            );
                            console.error(error);
                        });
                }
            });
        },


    },
};
</script>

<template>
    <div>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Sub Categories</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="#">Home</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    DataTables
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="p-2 mt-1 w-1/6">
                                <button
                                    type="button"
                                    class="btn btn-block btn-outline-success btn-sm"
                                    @click="storeSubCategory"
                                >
                                    Create
                                </button>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table
                                    id="example2"
                                    class="table table-bordered table-hover"
                                >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(category,
                                            index) in all_sub_categories"
                                            :key="category.id"
                                        >
                                            <td>
                                                {{
                                                    all_sub_categories.length -
                                                    1 -
                                                    index
                                                }}
                                            </td>
                                            <td>{{ category.name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button
                                                        type="button"
                                                        class="btn btn-info dropdown-toggle"
                                                        data-toggle="dropdown"
                                                        aria-expanded="false"
                                                        style="color: #117a8b"
                                                    >
                                                        <span
                                                            class="caret"
                                                        ></span>
                                                        <span class="sr-only"
                                                            >Toggle
                                                            Dropdown</span
                                                        >
                                                    </button>
                                                    <div
                                                        class="dropdown-menu"
                                                        role="menu"
                                                        x-placement="top-start"
                                                        style="
                                                            position: absolute;
                                                            will-change: transform;
                                                            top: 0px;
                                                            left: 0px;
                                                            transform: translate3d(
                                                                68px,
                                                                -2px,
                                                                0px
                                                            );
                                                        "
                                                    >
                                                        <a
                                                            class="dropdown-item"
                                                            href="#"
                                                            @click="
                                                                updateCategory(
                                                                    category.id
                                                                )
                                                            "
                                                            >Edit
                                                            <i
                                                                class="fa fa-edit"
                                                            ></i
                                                        ></a>
                                                        <div
                                                            class="dropdown-divider"
                                                        ></div>
                                                        <a
                                                            class="dropdown-item"
                                                            href="#"
                                                            @click="
                                                                deleteSubCategory(
                                                                    category.id
                                                                )
                                                            "
                                                            >Delete
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i
                                                        ></a>
                                                        <div
                                                            class="dropdown-divider"
                                                        ></div>
                                                        <!-- data-toggle="modal"
                                                            data-target="#show-modal-sm" -->
                                                        <a
                                                            class="dropdown-item"
                                                            href="#"
                                                            @click="
                                                                showSubCategoryModal(
                                                                    category.id
                                                                )
                                                            "
                                                            >Show
                                                            <i
                                                                class="fa fa-eye"
                                                            ></i
                                                        ></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>

        <!-- show -->
    </div>
</template>
