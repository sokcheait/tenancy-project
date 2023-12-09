export default [
    {
        header:{
            title:"Stock management",
            action:["supplier.index"]
        },
        submenu:[
            {
                lable: "Supplier",
                icon: "TruckIcon",
                link: "supplier.index",
                redirect: "supplier.index",
                seg: "supplier",
                type: "route"
            },
            {
                lable: "Item",
                icon: "CubeIcon",
                link: "item.index",
                redirect: "item.index",
                seg: "item",
                type: "route"
            },
            {
                lable: "Purchase Order",
                icon: "ShoppingCartIcon",
                link: "purchase-order.index",
                redirect: "purchase-order.index",
                seg: "purchase-order",
                type: "route"
            }
        ]
    },
]