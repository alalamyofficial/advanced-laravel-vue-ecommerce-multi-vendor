// categoryStore.js
import { defineStore } from 'pinia';
import axios from 'axios';

export const useCategoryStore = defineStore('category', {
  state: () => ({
    isModalOpen: false,
    modalCategory: {},
    all_categories: [],
    name: '',
    desc: '',
  }),
  getters: {
    getCategoryById: (state) => (id) =>
      state.all_categories.find((category) => category.id === id),
  },
  actions: {
    async fetchCategories() {
      try {
        const response = await axios.get('/all/categories');
        this.all_categories = response.data;
      } catch (error) {
        console.error(error);
      }
    },

    async showCategoryModal(id) {
      try {
        const response = await axios.get(`/categories/${id}`);
        this.modalCategory = response.data;

        Swal.fire({
            title: this.modalCategory.name,
            text: this.modalCategory.desc,
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
      } catch (error) {
        console.error(error);
      }
    },

    async storeCategory({ name, desc }) {
      try {
        const response = await axios.post('/categories', { name, desc });
        Swal.fire({
            title: "Create Category",
            html: `
                <div class="col-md-10 col-lg-10">
                    <input type="text" class="swal2-input form-control"
                    name="name" id="swal-name" placeholder="Enter ...">
                    <textarea class="swal2-textarea form-control" rows="3"
                    name="desc" id="swal-desc" placeholder="Enter ...">
                    </textarea>
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

                if (!name) {
                    Swal.showValidationMessage(
                        "Please enter a valid name."
                    );
                }
            },
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .post("/categories", { name, desc })
                    .then((response) => {
                        Swal.fire(
                            "Created!",
                            "Your category has been created.",
                            "success"
                        );
                        this.fetchCategories();
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
        this.fetchCategories();
      } catch (error) {
        // Handle error and Swal.fire here
        console.error(error);
      }
    },

    async updateCategory({ category, name, desc }) {
      try {
        const response = await axios.put(`/categories/${category}`, { name, desc });
        Swal.fire({
            title: "Update Category",
            html: `
                    <div class="col-md-10 col-lg-10">
                        <input type="text" class="swal2-input form-control"
                        name="name" id="swal-name" name="name"
                        value="${this.categoryDetails.name}"
                        placeholder="Enter ...">

                        <textarea class="swal2-textarea name="desc"
                            form-control col-md-12 col-lg-12" rows="6"
                            name="desc" id="swal-desc" placeholder="Enter ..."
                                style="width: 340px;">
                                ${this.categoryDetails.desc}
                        </textarea>
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

                if (!name) {
                    Swal.showValidationMessage(
                        "Please enter a valid name."
                    );
                }
            },
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .put("/categories/" + category, { name, desc })
                    .then((response) => {
                        Swal.fire(
                            "Updated!",
                            "Your category has been updated.",
                            "success"
                        );
                        this.fetchCategories();
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
        this.fetchCategories();
      } catch (error) {
        // Handle error and Swal.fire here
        console.error(error);
      }
    },

    async showDeleteModal(category) {
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
                    .delete(`/categories/${category}`)
                    .then((response) => {
                        Swal.fire(
                            "Deleted!",
                            "Your item has been deleted.",
                            "success"
                        );
                        this.fetchCategories();
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
      if (confirmed) {
        try {
          const response = await axios.delete(`/categories/${category}`);
          // Handle response and Swal.fire here
          this.fetchCategories();
        } catch (error) {
          // Handle error and Swal.fire here
          console.error(error);
        }
      }
    },
  },
});
