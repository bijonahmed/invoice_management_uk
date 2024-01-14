import { createWebHistory, createRouter } from "vue-router";
const Login = () => import("../pages/Login.vue");
const Register = () => import("../pages/Register.vue");
const Home = () => import("../pages/Home.vue");
const changesPassword = () => import("../pages/Users/ChangesPassword.vue");
/* *********************************** AUTHENTICAL ALL PAGE ********************************** */
const Dashboard = () => import("../pages/Dashboard.vue");
const Myprofile = () => import("../pages/Users/Mprofile.vue");
const companySetting = () => import("../pages/CompanySetting.vue");
const logActivity = () => import("../pages/Users/LogActivity.vue");
//User
const userlist = () => import("../pages/Users/Userlist.vue");
const editUser = () => import("../pages/Users/EditUser.vue");
const rolelist = () => import("../pages/Role/Rolelist.vue");
const addnewuser = () => import("../pages/Users/Addnewuser.vue");
//Member
const memberlist = () => import("../pages/Members/Memberlist.vue");
const editmember = () => import("../pages/Members/EditMember.vue");
const ipcheckerlist = () => import("../pages/Members/Ipcheckerlist.vue");
//KYC
const kyclist = () => import("../pages/Members/Kyclist.vue");
//Category
const addNewHashTag = () => import("../pages/Category/AddNewHashTag.vue");
const hashTagList = () => import("../pages/Category/HashTagList.vue");
const insubcategorylist = () =>
    import("../pages/Category/Insubcategorylist.vue");
const subcategorylist = () => import("../pages/Category/Subcategorylist.vue");
const categorylist = () => import("../pages/Category/Categorylist.vue");
const addNewCategory = () => import("../pages/Category/AddNewCategory.vue");
const addInNewSubCategory = () =>
    import("../pages/Category/AddInNewSubCategory.vue");
const addNewSubCategory = () =>
    import("../pages/Category/AddNewSubCategory.vue");
const editCategory = () => import("../pages/Category/EditCategory.vue");
const editInSubategory = () => import("../pages/Category/EditInSubategory.vue");
const editsubcategory = () => import("../pages/Category/Editsubcategory.vue");
const edithashTag = () => import("../pages/Category/EditHashtag.vue");
//Post
const postlist = () => import("../pages/Post/Postlist.vue");
const addnewPost = () => import("../pages/Post/AddnewPost.vue");
const editPost = () => import("../pages/Post/EditPost.vue");
// Bank List
const banklist = () => import("../pages/bank/Banklist.vue");
const addnewbank = () => import("../pages/bank/AddnewBank.vue");
const editbank = () => import("../pages/bank/EditBank.vue");
//Filter
const categoryFilter = () => import("../pages/Post/CategoryFilter.vue");
const hashtagFilter = () => import("../pages/Post/HashTagFilter.vue");
//Request
const depositlist = () => import("../pages/Request/DepositList.vue");
const withdrawlist = () => import("../pages/Request/Withdrawlist.vue");
const livestream = () => import("../pages/LivePost/Livestream.vue");
// customer list
const customerlist = () => import("../pages/Customer/Customerlist.vue");
const addnewcustomer = () => import("../pages/Customer/AddNewCustomer.vue");
const editcustomer = () => import("../pages/Customer/Editcustomer.vue");
//supplier
const supplierlist = () => import("../pages/Supplier/Supplierlist.vue");
const addnewsupplier = () => import("../pages/Supplier/Adnewsupplier.vue");
const editsupplier = () => import("../pages/Supplier/EditSupplier.vue");
const supplierdueamtlist = () =>
    import("../pages/Supplier/Supplierdueamtlist.vue");
const addnewdueamount = () => import("../pages/Supplier/Addnewdueamount.vue");
const editdueamount = () => import("../pages/Supplier/Editdueamount.vue");
const supplierpaymentlist = () =>
    import("../pages/Supplier/SupplierPaymentList.vue");
const addnewsupppayments = () =>
    import("../pages/Supplier/AddnewSuppPayments.vue");
const editpaidamount = () => import("../pages/Supplier/Editpaidamount.vue");
//Invoice list
const invoicereturn = () => import("../pages/Invoice/Invoicereturnlist.vue");
const invoicelist = () => import("../pages/Invoice/Invoicelist.vue");
const listmoneytransfer = () => import("../pages/Invoice/InvoicelistMoney.vue");
const listothersInvoice = () =>
    import("../pages/Invoice/InvoicelistOthers.vue");
const addnewinvoice = () => import("../pages/Invoice/CreateInvoice.vue");
const addnewinvoiceRefund = () =>
    import("../pages/Invoice/CreateInvoiceReturn.vue"); //import('../pages/Invoice/CreateInvoiceReturn.vue')
const addnewinvoiceMoney = () =>
    import("../pages/Invoice/AddnewInvoiceMoney.vue");
const addnewOthersInv = () => import("../pages/Invoice/AddnewOthersInv.vue");
const printpreviewinvoice = () =>
    import("../pages/Invoice/Printpreviewinvoice.vue");
const editmoneyinvoice = () => import("../pages/Invoice/EditInvoiceMoney.vue");
const edittravelinvoice = () =>
    import("../pages/Invoice/EditTravelInvoice.vue");
const editOthresinvoice = () =>
    import("../pages/Invoice/EditOthresinvoice.vue");
const Printmoneyinvoice = () =>
    import("../pages/Invoice/Printmoneyinvoice.vue");
const PrintOthersinvoice = () =>
    import("../pages/Invoice/PrintOthersinvoice.vue");
    
// Report
const profit = () => import("../pages/Report/Profit.vue");
const due = () => import("../pages/Report/Due.vue");
/* *********************************** END AUTHENTICAL ALL PAGE ********************************** */
import store from "../store";
const routes = [
    // { path: "/", name: "Home", component: Home },
    //{ path: "/", name: "Home", component: Home },
    { path: "/", name: "Home", component: Home, meta: { requiresAuth: false } },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: { requiresAuth: false },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: { requiresAuth: false },
    },
    /* *********************************** AUTHENTICAL URL ********************************** */
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
        meta: { requiresAuth: true },
    },
    //User
    {
        path: "/my-profile",
        name: "my-profile",
        component: Myprofile,
        meta: { requiresAuth: true },
    },
    {
        path: "/changes-password",
        name: "changes-password",
        component: changesPassword,
        meta: { requiresAuth: true },
    },
    {
        path: "/company-setting",
        name: "company-setting",
        component: companySetting,
        meta: { requiresAuth: true },
    },
    {
        path: "/user-list",
        name: "userlist",
        component: userlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-user/:id",
        name: "edit-user",
        component: editUser,
        meta: { requiresAuth: true },
    },
    {
        path: "/role-list",
        name: "rolelist",
        component: rolelist,
        meta: { requiresAuth: true },
    },
    {
        path: "/add-new-user",
        name: "add-new-user",
        component: addnewuser,
        meta: { requiresAuth: true },
    },
    {
        path: "/log/log-activity",
        name: "log-activity",
        component: logActivity,
        meta: { requiresAuth: true },
    },
    //Member
    {
        path: "/member/member-list",
        name: "memberlist",
        component: memberlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-member/:id",
        name: "edit-member",
        component: editmember,
        meta: { requiresAuth: true },
    },
    {
        path: "/member/ip-checker",
        name: "ipcheckerlist",
        component: ipcheckerlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/member/kyc-list",
        name: "kyclist",
        component: kyclist,
        meta: { requiresAuth: true },
    },
    //Category
    {
        path: "/category/in-subcategory-list",
        name: "in-subcategory-list",
        component: insubcategorylist,
        meta: { requiresAuth: true },
    },
    {
        path: "/category/add-new-in-sub-category",
        name: "add-new-in-sub-category",
        component: addInNewSubCategory,
        meta: { requiresAuth: true },
    },
    {
        path: "/category/add-new-hash-tag",
        name: "add-new-hash-tag",
        component: addNewHashTag,
        meta: { requiresAuth: true },
    },
    {
        path: "/category/hash-tag-list",
        name: "hash-tag-list",
        component: hashTagList,
        meta: { requiresAuth: true },
    },
    {
        path: "/category/add-new-sub-category",
        name: "add-new-sub-category",
        component: addNewSubCategory,
        meta: { requiresAuth: true },
    },
    {
        path: "/category/subcategory-list",
        name: "subcategory-list",
        component: subcategorylist,
        meta: { requiresAuth: true },
    },
    {
        path: "/category/add-new-category",
        name: "add-new-category",
        component: addNewCategory,
        meta: { requiresAuth: true },
    },
    {
        path: "/category/category-list",
        name: "category-list",
        component: categorylist,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-category/:id",
        name: "edit-category",
        component: editCategory,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-sub-category/:id",
        name: "edit-sub-category",
        component: editsubcategory,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-hashTag/:id",
        name: "edit-hashTag",
        component: edithashTag,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-in-sub-category/:id",
        name: "edit-in-sub-category",
        component: editInSubategory,
        meta: { requiresAuth: true },
    },
    //Post
    {
        path: "/post/post-list",
        name: "post-list",
        component: postlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/post/add-new-post",
        name: "add-new-post",
        component: addnewPost,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-post/:id",
        name: "edit-post",
        component: editPost,
        meta: { requiresAuth: true },
    },
    //Bank
    {
        path: "/bank/bank-list",
        name: "bank-list",
        component: banklist,
        meta: { requiresAuth: true },
    },
    {
        path: "/bank/add-new-bank",
        name: "add-new-bank",
        component: addnewbank,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-bank/:id",
        name: "edit-bank",
        component: editbank,
        meta: { requiresAuth: true },
    },
    //Filter
    {
        path: "/category-filter",
        name: "category-filter",
        component: categoryFilter,
        meta: { requiresAuth: true },
    },
    {
        path: "/hashtag-filter",
        name: "hashtag-filter",
        component: hashtagFilter,
        meta: { requiresAuth: true },
    },
    //Request
    {
        path: "/deposit/deposit-list",
        name: "depositlist",
        component: depositlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/withdraw/withdraw-list",
        name: "withdrawlist",
        component: withdrawlist,
        meta: { requiresAuth: true },
    },
    // stream/live-stream
    {
        path: "/stream/live-stream",
        name: "live-stream",
        component: livestream,
        meta: { requiresAuth: true },
    },
    //customer
    {
        path: "/customer/customer-list",
        name: "customerlist",
        component: customerlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/customer/add-new-customer",
        name: "addnewcustomer",
        component: addnewcustomer,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-customer/:id",
        name: "edit-customer",
        component: editcustomer,
        meta: { requiresAuth: true },
    },
    //supplier
    {
        path: "/supplier/supplier-list",
        name: "supplierlist",
        component: supplierlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/supplier/add-new-supplier",
        name: "addnewsupplier",
        component: addnewsupplier,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-supplier/:id",
        name: "edit-supplier",
        component: editsupplier,
        meta: { requiresAuth: true },
    },
    {
        path: "/supplier/supplier-due-amt-list",
        name: "supplierdueamtlist",
        component: supplierdueamtlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/supplier/add-new-due-amount",
        name: "addnewdueamount",
        component: addnewdueamount,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-due-amount/:id",
        name: "edit-due-amount",
        component: editdueamount,
        meta: { requiresAuth: true },
    },
    {
        path: "/supplier/supplier-payment-list",
        name: "supplierpaymentlist",
        component: supplierpaymentlist,
        meta: { requiresAuth: true },
    },
    {
        path: "/supplier/add-new-supp-payments",
        name: "addnewsupppayments",
        component: addnewsupppayments,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-paid-amount/:id",
        name: "edit-paid-amount",
        component: editpaidamount,
        meta: { requiresAuth: true },
    },
    //Invoice
    {
        path: "/invoice/invoice-list",
        name: "invoicelist",
        component: invoicelist,
        meta: { requiresAuth: true },
    },
    {
        path: "/invoice/invoice-list-money-transfer",
        name: "invoice-listmoneytransfer",
        component: listmoneytransfer,
        meta: { requiresAuth: true },
    },
    {
        path: "/invoice/invoice-list-others",
        name: "invoice-listothers",
        component: listothersInvoice,
        meta: { requiresAuth: true },
    },
    {
        path: "/invoice/addnewinvoice",
        name: "addnewinvoice",
        component: addnewinvoice,
        meta: { requiresAuth: true },
    },
    {
        path: "/invoice/addnewinvoiceRefund",
        name: "addnewinvoiceRefund",
        component: addnewinvoiceRefund,
        meta: { requiresAuth: true },
    },
    {
        path: "/invoice/addnewinvoiceMoney",
        name: "addnewinvoiceMoney",
        component: addnewinvoiceMoney,
        meta: { requiresAuth: true },
    },
    {
        path: "/invoice/addnewOthersInv",
        name: "addnewOthersInv",
        component: addnewOthersInv,
        meta: { requiresAuth: true },
    },
    {
        path: "/invoice/invoice-refund",
        name: "invoicereturn",
        component: invoicereturn,
        meta: { requiresAuth: true },
    },
    {
        path: "/print-preview-invoice/:id",
        name: "print-preview-invoice",
        component: printpreviewinvoice,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-money-invoice/:id",
        name: "edit-money-invoice",
        component: editmoneyinvoice,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-others-invoice/:id",
        name: "edit-others-invoice",
        component: editOthresinvoice,
        meta: { requiresAuth: true },
    },
    {
        path: "/print-money-invoice/:id",
        name: "print-money-invoice",
        component: Printmoneyinvoice,
        meta: { requiresAuth: true },
    },
    {
        path: "/print-others-invoice/:id",
        name: "print-others-invoice",
        component: PrintOthersinvoice,
        meta: { requiresAuth: true },
    },
    {
        path: "/edit-travel-invoice/:id",
        name: "edit-travel-invoice",
        component: edittravelinvoice,
        meta: { requiresAuth: true },
    },
    //Reprot
    {
        path: "/report/profit",
        name: "profit",
        component: profit,
        meta: { requiresAuth: true },
    },
    {
        path: "/report/due",
        name: "due",
        component: due,
        meta: { requiresAuth: true },
    },
];
const router = createRouter({
    history: createWebHistory(),
    // mode: "history",
    routes,
});

export default router;
