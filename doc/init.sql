insert  into `role`(`id`,`name`) values (1,'普通用户'),(2,'管理员'),(3,'超级管理员');
insert  into `user`(`id`,`user_name`,`nick_name`,`password`,`email`,`phone`,`role`,`create_time`) values (1,'admin','曹青杰','e10adc3949ba59abbe56e057f20f883e','3333333@qq.com','15212341234','1','2015-11-24 13:14:05');
insert  into `deliver`(`id`,`name`,`status`,`remark`,`ctime`) values (1,'中通',1,NULL,NULL),(2,'申通',1,NULL,NULL),(3,'顺丰',1,NULL,NULL),(4,'京东',1,NULL,NULL);
