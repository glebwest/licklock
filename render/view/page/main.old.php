
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<style>

#click {
    margin: 30vh auto;
    padding: 10px;
    border-radius: 10px;
    background: darkblue;
    color: whitesmoke;
    font-size: 30px;
    text-align: center;
}


</style>

<div id="click">Click on me!!</div>

<script>


const delay = ms => {
    return new Promise(r => setTimeout( ()=> r(), ms))
}

async function getData(url,object,toDo = function(object){}) {
    // console.log(object)
    try {
        await delay(100)
        const response = await fetch (url,{
            method: 'POST',
            headers: {
                'Content-Type':'application/json; charset=utf-8'
            },
            body: JSON.stringify(object)
        })

        const data = await response.json()

        answer = data
        toDo(answer)
    } catch (e) {
        console.error(e) || toDo('SERVER ERROR. TRY LATER')
    }
}


click.addEventListener('click',(e)=>{
    e.preventDefault()
    getData(
        '/api.php',
        {
            'method' : 'test',
            'token' : 'QUMHlRKHklvpStnf',
            'data' : 'this is data'
        },
        (ans)=>{
            console.log(ans)
        }
    )
})

</script>
</body>
</html>