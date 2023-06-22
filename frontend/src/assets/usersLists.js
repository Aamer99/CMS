import departmentIcon from "./icons/departments.png";
import homeIcon from "./icons/home.png";
import requestColor from "./icons/requests.png";
import managersIcon from "./icons/managers.png";
import sendMessageIcon from "./icons/message.png";

export const adminList=[
    {
      id:0,
      title: "Home",
      value: 0,
    //   src: homeIcon,
    //   alt:"Home Icon",
    //   destination:'/admin'
    },
    {
      id:1,
      title: 'Department',
      value: 1,
    //   src: departmentIcon,
    //   alt:"department icon",
    //   destination:'/admin/department'
    },
    {
        id:2,
      title: 'Request',
      value: 2,
    //   src: requestColor,
    //   alt:"requests icon",
    //   destination:'/admin/requests'
    },
    {
        id:3,
      title: 'Manager',
      value: 3,
    //   src: managersIcon,
    //   alt:"people icon",
    //   destination:'/admin/managers'
    },
    {
        id:4,
      title: 'Send Message',
      value:4,
    //   src: sendMessageIcon,
    //   alt:"send message icon",
    //   destination:'/admin/send-message'
    }

  ];

  export const managerList=[
    {
      title: "Home",
      value: 0,
      src: homeIcon,
      alt:"Home Icon",
      destination: '/manager'
    },
    {
      title: 'Employees',
      value: 1,
      src: departmentIcon,
      alt:"department icon",
      destination: '/manager/employee'
    },
    {
      title: 'Employees Requests',
      value: 2,
      src: requestColor,
      alt:"requests icon",
      destination: '/manager/employee-requests'
    },
    {
      title: 'My Request',
      value: 3,
      src: managersIcon,
      alt:"people icon",
      destination: '/manager/my-requests'
    },
    {
      title: 'Send Message',
      value:4,
      src: sendMessageIcon,
      alt:"send message icon",
      destination: '/manager/send-message'
    }

  ];
  export const employeeList=[
    {
      title: "Home",
      value: 0,
      src: homeIcon,
      alt:"Home Icon",
      destination: '/manager'
    },
    {
      title: 'Employees',
      value: 1,
      src: departmentIcon,
      alt:"department icon",
      destination: '/manager/employee'
    },
    {
      title: 'Employees Requests',
      value: 2,
      src: requestColor,
      alt:"requests icon",
      destination: '/manager/employee-requests'
    },
    {
      title: 'My Request',
      value: 3,
      src: managersIcon,
      alt:"people icon",
      destination: '/manager/my-requests'
    },
    {
      title: 'Send Message',
      value:4,
      src: sendMessageIcon,
      alt:"send message icon",
      destination: '/manager/send-message'
    }

  ]