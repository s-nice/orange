#/bin/bash
# 删除旧文件，释放磁盘空间
# @Author: Kilin WANG <wangkilin@126.com>
# @Date: 2014-09-24

# 加载配置文件
. ./Cron.conf

# 循环删除指定目录下的缓存文件
for Folder in ${delDirArr[@]};
do
	# 根据=>拆分临时目录与该临时文件保留时间 eg:Public/temp/Upload=>2
	Folder=(${Folder/=>/ })
	keepDays=${Folder[@]:1:1}
	Folder=${Folder[@]:0:1}
	if [ "$keepDays" -gt 0 ] 2>/dev/null ;
	then
	else
		keepDays=${keepTempDays}
	fi
	if [ "$Folder" != '' ];
	then
		# 删除名片缓存目录下修改时间超过30天的文件
		find "$AppBasePath$Folder" 2>/dev/null -mtime "$keepDays" -exec rm -fr '{}' \;
	fi
done

#exit 0
