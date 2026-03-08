function featureDetail() {
    return {
        addSubModal: { open: false, type: 'link' },
        editSubModal: { open: false, id: null, name: '', type: 'link', path: '', order: 0 },
        deleteSubModal: { open: false, id: null, name: '' },

        openAddSubModal() {
            this.addSubModal = { open: true, type: 'link' };
        },
        openEditSubModal(id, name, type, path, order) {
            this.editSubModal = { open: true, id, name, type, path, order };
        },
        openDeleteSubModal(id, name) {
            this.deleteSubModal = { open: true, id, name };
        }
    }
}
