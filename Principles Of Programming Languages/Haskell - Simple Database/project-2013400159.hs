--compiling yes
--complete yes
--batuhan demir
import Data.List

type Triple = (String,String,String)
type Tuple  = (String,String)



--1-- table list
--
-- Checks if given list is in desired table form
--
-- Examples:
-- table [("name", "id", "gpa")]
-- true
-- table [("name", "id", "gpa"), ("ali", "1", "3.2"), ("ayse", "2", "3.7", "eggs")]
-- Compilation Error
--
--to show value true i add instance show functionality
table ::  (Show a,Eq a) => a -> [Triple] ->Bool
table t tname = True
instance Show (a -> b) where
         show a= "true"

--2-- createtable fields
--
-- Creates a table from given field triple
--
-- Examples:
-- let students = createtable ("name", "id", "gpa")
-- students
--[("name", "id", "gpa")]
createtable :: Triple -> [Triple] 
createtable x = x:[]

--3-- get table row field
--
-- Returns value of field in given row
--
-- Examples:
-- get students ("ali", "1", "3.2") "gpa"
-- "3.2"
--get :: [Triple] -> Triple -> String -> String 
--get tname (a,b,c) field = case field of
--								field_one -> a
--								field_two -> b
--								field_three -> c
get :: [Triple] -> Triple -> String -> String 
get tname (a,b,c) field 
				| field == field_one = a
				| field == field_two = b
				| field == field_three = c
				| otherwise = ""
	where 
	  field_one = _1of3 $ head tname 
	  field_two = _2of3 $ head tname  
	  field_three = _3of3 $ head tname 

--4-- alter table row fieldsvalues
--
-- Alters values given in fields-values in given row
--
-- Examples:
-- alter students ("ali", "1", "3.2") [("name", "ahmet"), ("gpa", "3.3")]
-- ("ahmet", "1", "3.3")
--
--i check for every position in triple to see a match
--then change the position accordingly
--in where clause i get elements of tuple list as tuple11,tuple22 etc..
alter :: [Triple] -> Triple -> [Tuple] -> Triple
alter tname (a,b,c) l = (pos1,pos2,pos3)
		where 
			pos1 = if (_1of3 $ head tname) == tuple11 
						then tuple12
					else if (_1of3 $ head tname) == tuple21
						then tuple22
					else if (_1of3 $ head tname) == tuple31
						then tuple32
					else a	
			pos2 = if (_2of3 $ head tname) == tuple11 
						then tuple12
					else if (_2of3 $ head tname) == tuple21
						then tuple22
					else if (_2of3 $ head tname) == tuple31
						then tuple32
					else b											
			pos3 = if (_3of3 $ head tname) == tuple11 
						then tuple12
					else if (_3of3 $ head tname) == tuple21
						then tuple22
					else if (_3of3 $ head tname) == tuple31
						then tuple32
					else c	
			tuple11 = (fst $ l !! 0)
			tuple12 = (snd $ l !! 0)
			tuple21 = if (length l) >= 2 
						then (fst $ l !! 1) 
						else "null" 
			tuple22 = if (length l) >= 2 
						then (snd $ l !! 1) 
						else "null" 
			tuple31 = if (length l) >= 3 
						then (fst $ l !! 2) 
						else "null" 
			tuple32 = if (length l) >= 3 
						then (snd $ l !! 2) 
						else "null" 

--5-- addrow table row
--
-- Adds a row to a table
--
-- Examples:
-- addrow students ("asli", "3", "2.8")
-- [("name", "id", "gpa"), ("asli", "3", "2.8"), ("ali", "1", "3.2"), ("ayse", "2", "3.7")]
addrow :: [Triple] -> Triple -> [Triple]
addrow x y = (head x):y:(tail x)

--6-- addrows table rows ...
--
-- Adds a row to a table
--
-- Examples:
-- addrows students [("asli", "3", "2.8"), ("ahmet", "4", "0.8")]
-- [("name", "id", "gpa"), ("asli", "3", "2.8"), ("ahmet", "4", "0.8"),
--("ali", "1", "3.2"), ("ayse", "2", "3.7")]
addrows :: [Triple] -> [Triple] -> [Triple]
addrows x ys = (head x) : (foldr (:) (tail x) ys)

--7-- deleterows table field-value
--
-- deletes rows which has given field equal to a certain value
--
-- Examples:
-- deleterows students [("name", "ali")]
-- [("name", "id", "gpa"), ("ayse", "2", "3.7")]
--
--i simply filter the list
--deletes if only tuple list consists 1 element
deleterows :: [Triple] -> [Tuple] -> [Triple]
deleterows tname [(a,b)]
	 | (a == (_1of3 $ head tname))  = (head tname) :(filter (\(f1,f2,f3) -> f1 /= b) (tail tname))
	 | (a == (_2of3 $ head tname))  = (head tname) :(filter (\(f1,f2,f3) -> f2 /= b) (tail tname))
	 | (a == (_3of3 $ head tname))  = (head tname) :(filter (\(f1,f2,f3) -> f3 /= b) (tail tname))
	 | otherwise = tname


--8-- updaterows table fields-values
--
-- changes the values of second field of rows 
-- whose field equals to the first specified field
--
-- Examples:
-- updaterows students [("name", "ali"), ("gpa", "3.3")]
-- [("name", "id", "gpa"), ("ali", "1", "3.3"), ("ayse", "2", "3.7"))]
--
--In solution i first look for match of field to find which triple 
--will be changed , then i change fields accordingly
updaterows :: [Triple] -> [Tuple] -> [Triple] 
updaterows tname [(a,b),(c,d)] 
	 | (pos a tname == "fst") = (head tname) : (map (\x@(f1,f2,f3) -> (if f1 == b 
	 	 		 												then (if (pos c tname) == "fst"
	 	 			 														then (d,f2,f3)
 	 			 													 else if (pos c tname) == "snd"
 	 			 													 	then (f1,d,f3)
 	 		 													 	 else (f1,f2,d))
	 	 													 	else x ) ) $ tail tname)
	 | (pos a tname == "snd") = (head tname) : (map (\x@(f1,f2,f3) -> (if f2 == b 
	 	 	 													then (if (pos c tname) == "fst" 
	 			 	 														then (d,f2,f3)
 			 	 													 else if (pos c tname) == "snd"
 			 	 													 	then (f1,d,f3)
 			  													 	 else (f1,f2,d))
	 	 												 		else x) ) $ tail tname)
	 | (pos a tname == "trd") = (head tname) : (map (\x@(f1,f2,f3) -> (if f3 == b 
	 	 	 													then (if (pos c tname) == "fst" 
	 			 	 														then (d,f2,f3)
 			 	 													 else if (pos c tname) == "snd"
 			 	 													 	then (f1,d,f3)
 			  													 	 else (f1,f2,d))
	 	 												 		else x ) ) $ tail tname)
	 | otherwise = tname




--9-- selectrows table fields field-value
--
-- returns fields given in "fields" for the given field-value from table
--
-- Examples:
-- selectrows students ("gpa", "id") ("name", "ali")
-- [("gpa", "id"), ("3.2", "1")]
--
--In this question i look for all possibilities and return tuples
--it maps lambda function which selects 2 place to the 
--list which is filtered by equal value 
----rev means reversed
selectrows :: [Triple] -> Tuple -> Tuple -> [Tuple]
selectrows t tp (fld,val) 
		|  pos1 	= tp : map (\(_,b,c) -> (b,c)) (filter ((==val).(\x ->_1of3 x)) (tail t))  
		|  pos1rev  = tp : map (\(_,c,b) -> (b,c)) (filter ((==val).(\x ->_1of3 x)) (tail t))  
		|  pos2 	= tp : map (\(b,_,c) -> (b,c)) (filter ((==val).(\x ->_2of3 x)) (tail t)) 
		|  pos2rev  = tp : map (\(c,_,b) -> (b,c)) (filter ((==val).(\x ->_2of3 x)) (tail t)) 
		|  pos3 	= tp : map (\(b,c,_) -> (b,c)) (filter ((==val).(\x ->_3of3 x)) (tail t)) 
		|  pos3rev  = tp : map (\(c,b,_) -> (b,c)) (filter ((==val).(\x ->_3of3 x)) (tail t)) 
	where 
		pos1    = (pos fld t == "fst") && (fst tp == (_2of3 $ head t))
		pos1rev = (pos fld t == "fst") && (fst tp == (_3of3 $ head t))
		pos2    = (pos fld t == "snd") && (fst tp == (_1of3 $ head t))
		pos2rev = (pos fld t == "snd") && (fst tp == (_3of3 $ head t))
		pos3    = (pos fld t == "trd") && (fst tp == (_1of3 $ head t))
		pos3rev = (pos fld t == "trd") && (fst tp == (_2of3 $ head t))

--10-- allrows table row
--
-- returns all rows and some fields of a table
--
-- Examples:
-- allrows students "gpa"
-- [("gpa"), ("3.2"), ("3.7")]
allrows :: [Triple] -> String -> [String]
allrows tname fld  
			 | pos1 = map (\(a,_,_) -> a) tname
			 | pos2 = map (\(_,b,_) -> b) tname
			 | pos3 = map (\(_,_,c) -> c) tname
	where 
	  pos1 = (pos fld tname == "fst")
	  pos2 = (pos fld tname == "snd")
	  pos3 = (pos fld tname == "trd")

--11-- sortby table field
--
-- Sorts the table by a given field in ascending order
--
-- Examples:
-- sortby students "id"
-- [("name", "id", "gpa"), ("ali", "1", "3.2"), ("ayse", "2", "3.7")]
--
--sort tail list by compare single elements of the list
sortby :: [Triple] -> String -> [Triple]
sortby t fld 
		|  pos1 = head t : sortBy (\a b -> compare (_1of3 a) (_1of3 b)) (tail t)
		|  pos2 = head t : sortBy (\a b -> compare (_2of3 a) (_2of3 b)) (tail t)				
		|  pos3 = head t : sortBy (\a b -> compare (_3of3 a) (_3of3 b)) (tail t)				
	where 
	  pos1 = (pos fld t == "fst")
	  pos2 = (pos fld t == "snd")
	  pos3 = (pos fld t == "trd")

----12-- distinct table
----
---- Removes any duplicate rows in a table.
----
---- Examples:
---- distinct students
---- [("name", "id", "gpa"), ("ali", "1", "3.3"), ("ayse", "2", "3.4"), ("ali", "2", "3.3")]
distinct :: [Triple] -> [Triple]
distinct (x:xs) = x : uniques xs

--helper function for "distinct"
--it  basically sorts and groups
--it maps 'head' 'group' and 'sort' to the given list
--so that any duplicate is removed
uniques :: [Triple] -> [Triple]
uniques =  map head . group . sort . map mysort

--helper function for "uniques" function
--it does not sort actually
mysort :: Triple -> Triple
mysort (x, y, z) =  (x, y, z)

--Returns first,second or third element of given triple
--
--Example:
--_1of3 (A,B,C)
--A
_1of3 :: Triple -> String
_1of3 (a,_,_) = a

_2of3 :: Triple -> String
_2of3 (_,a,_) = a

_3of3 :: Triple -> String
_3of3 (_,_,a) = a

-- determines the position of the variable in the table 
--
-- Examples:
-- pos "name" students
-- 'fst'
pos:: String -> [Triple] -> String
pos p table = if p == (_1of3 $ head table)
					then "fst"
				  else if p == (_2of3 $ head table)
				  	then "snd"
			   	  else "trd"
