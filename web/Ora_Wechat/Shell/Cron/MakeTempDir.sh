#!/bin/bash
# 判断项目中temp文件夹下的目录是否存在 不存在则创建
# @Author: jiyl <jiyl@oradt.com>
# @Date: 2016-3-17

# 加载配置文件
. ./Cron.conf
# 循环判断指定目录是否存在 并修改目录权限为777
for tempArr in ${tempDirArr[@]};
do
	# 根据=>拆分目录与子集 
	# eg:'Public/temp/=>temp1/,temp2/' 第一部分是temp目录 第二部分是temp的子集
	tempArr=(${tempArr/=>/ })
	tempDir=${tempArr[@]:0:1}
	tempArr=${tempArr[@]:1:1}
	# 根据,拆分目录子集 eg:'temp1,temp2,temp3'
	dirArr=(${tempArr//,/ })
	for x in ${dirArr[@]};
	do
		i=1
		# 拼接temp的绝对路径
		dirNew=${AppBasePath}${tempDir}
		mkdir -p ${dirNew}
		chmod 777 ${dirNew}
		#循环创建多级目录
		while(true)
		do
			dirOption=`echo $x|cut -d "/" -f$i`
			#判断切割的字段是否为空 空则跳出 不为空则拼接目录并创建
			if [ "$dirOption" != "" ];
			then
				((i++))
				# 拼接新目录
				dirNew=${dirNew}${dirOption}'/'
				
				# 判断目录是否存在
				if [ ! -d "$dirNew" ];
				then
					mkdir -p "$dirNew"
				fi
			else
				break
			fi
			
			# 修改目录权限
			chmod 777 "$dirNew"
			echo "add TempDir : $dirNew"
		done
	done
done


