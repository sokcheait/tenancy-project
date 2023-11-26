export default [
    {
        header:{
            title:"stock_management",
            action:["supplier","item","purchase-order","receive","back-order","stock","returned"]
        },
        lable: "supplier",
        icon: "TruckIcon",
        link: "supplier.index",
        redirect: "supplier.index",
        seg: "supplier",
        type: "route",
        parent: "supplier"
    },
    {
        lable: "item",
        icon: "RectangleGroupIcon",
        link: "item.index",
        redirect: "item.index",
        seg: "item",
        type: "route",
        parent: "item"
    },
    {
        lable: "purchase_order",
        icon: "ListBulletIcon",
        link: "purchase-order.index",
        redirect: "purchase-order.index",
        seg: "purchase-order",
        type: "route",
        parent: "purchase-order"
    },
    {
        lable: "receiving",
        icon: "ClipboardDocumentListIcon",
        link: "receive.index",
        redirect: "receive.index",
        seg: "receive",
        type: "route",
        parent: "receive"
    },
    {
        lable: "back_order",
        icon: "ArrowsRightLeftIcon",
        link: "back-order.index",
        redirect: "back-order.index",
        seg: "back-order",
        type: "route",
        parent: "back-order"
    },
    {
        lable: "stock",
        icon: "CubeIcon",
        link: "stock.index",
        redirect: "stock.index",
        seg: "stock",
        type: "route",
        parent: "stock"
    },
    {
        lable: "returned",
        icon: "ArrowUturnLeftIcon",
        link: "returned.index",
        redirect: "returned.index",
        seg: "returned",
        type: "route",
        parent: "returned"
    },
]