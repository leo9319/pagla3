<template>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Date</th>
                    <th>Invoice ID</th>
                    <th>Client Code</th>
                    <th>Client Name</th>
                    <th>Sales (Before Vat)</th>
                    <th>Sales (After Vat)</th>
                    <th>Remarks</th>
                    <th>Invoice</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL.</th>
                    <th>Date</th>
                    <th>Invoice ID</th>
                    <th>Client Code</th>
                    <th>Client Name</th>
                    <th>Sales (Before Vat)</th>
                    <th>Sales (After Vat)</th>
                    <th>Remarks</th>
                    <th>Invoice</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script type="text/javascript">
    import axios from 'axios';
    export default {
        methods: {
            getSales() {
                axios.get('api/sales/get-sales')
                    .then(response => console.log(response.data))
                    .catch(error => console.log(error))
            }
        },
        created() {
            this.getSales()
        }
    }
</script>