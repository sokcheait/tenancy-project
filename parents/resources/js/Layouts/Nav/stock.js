export default [
    {
        header:{
            title:"Stock management",
            action:["supplier","item","purchase-order"]
        },
        lable: "Supplier",
        icon: "TruckIcon",
        link: "supplier.index",
        redirect: "supplier.index",
        seg: "supplier",
        type: "route",
        parent: "supplier"
    },
    {
        lable: "Item",
        icon: "RectangleGroupIcon",
        link: "item.index",
        redirect: "item.index",
        seg: "item",
        type: "route",
        parent: "item"
    },
    {
        lable: "Purchase order",
        icon: "NewspaperIcon",
        link: "purchase-order.index",
        redirect: "purchase-order.index",
        seg: "purchase-order",
        type: "route",
        parent: "purchase-order"
    }
]