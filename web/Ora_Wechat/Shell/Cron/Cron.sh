#!/bin/bash
# 创建临时目录 增加定时任务 生成敏感词缓存文件 
# @Author: jiyl <jiyl@oradt.com>
# @Date: 2016-3-18

# 加载配置文件
. ./Cron.conf
# 创建临时文件
sh MakeTempDir.sh
# 添加定时任务
touch ${cronFile}
# 每日凌晨1点 清除临时文件中部分文件
echo "* 1 * * * nobody cd $AppBasePath/Cron && sh RemoveOldFiles.sh" > ${cronFile}
# 每日凌晨1点 生成敏感词缓存文件
echo "* 1 * * * nobody curl $scheduleUrl" >> ${cronFile}
echo "add crontab to $cronFile"
service crond restart 2>/dev/null
# 生成敏感词缓存文件
curl "$scheduleUrl" 2>/dev/null
