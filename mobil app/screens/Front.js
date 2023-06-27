import React, { Component } from 'react';
import { View, Text, TextInput, Button, ScrollView } from 'react-native';
import { style } from './../compontents/StyleAdmin';

class Front extends Component  {
    constructor(props) {
        super(props);
            this.state = {
                username:'',
                no_hash:'',
                listData:[],
                idEdit:null,
            };
            this.url="http://192.168.26.218/Integralt/api.php";
    }
    componentDidMount(){
        this.requestListData();
    }
    
    async requestListData(){
        await fetch(this.url)
        .then((response)=>response.json())
        .then((json)=>{
            console.log('The results: '+JSON.stringify(json.data.result));
            this.setState({listData:json.data.result});
        })
        .catch((error)=>{
            console.log(error);
        })
    }
    
    pressButton(){
        if(this.state.username == '' || this.state.no_hash == ''){
            alert('Kérlek add meg a jelszavat és a nevet!');
        }else{
            if(this.state.idEdit){
                var urlOperation = this.url+"/?op=update&user_id="+this.state.idEdit;
            }else{
                var urlOperation = this.url+"/?op=create";
            }
        
            fetch(urlOperation,{
                method:'post',
                headers:{
                    'Content-Type':'application/x-www-form-urlencoded'
                },
                body:"username="+this.state.username+"&no_hash="+this.state.no_hash
            })
            .then((response)=>response.json())
            .then((json)=>{
                this.setState({username:''});
                this.setState({no_hash:''});
                this.requestListData();
            })
        }
    }
    
    async clickEdit(user_id){
        await fetch(this.url+"/?op=detail&user_id="+user_id)
        .then((response)=>response.json())
        .then((json)=>{
            this.setState({username:json.data.result[0].username});
            this.setState({no_hash:json.data.result[0].no_hash});
            this.setState({idEdit:user_id})
        })
    }
    
    async clickDelete(user_id){
        await fetch(this.url+"/?op=delete&user_id="+user_id)
        .then((response)=>response.json())
        .then((json)=>{
            alert('The user deleted!');
            this.requestListData();
        })
        .catch((error)=>{
            console.log(error)
        })
    }
    
      //Table Headings


    render() {
        return (
            <View style={style.viewWrapper}>
                <ScrollView style={{}}>
                <View style={style.viewData}>
                    {
                        this.state.listData.map((val, index)=>(
                           <View style={style.viewList} key={index}>
                                <Text style={style.textListName}>
                                    {val.username}
                                </Text>
                                <Text style={style.textListEdit} onPress={()=>this.clickEdit(val.user_id)}>Edit</Text>
                                <Text style={style.textListDelete} onPress={()=>this.clickDelete(val.user_id)}>Delete</Text>
                           </View> 
                        ))
                    }
                </View>
                </ScrollView>
                <View style={style.viewForm}>
                    <TextInput 
                        style={style.textInput}
                        placeholder="Név!"
                        value={this.state.username}
                        onChangeText={(text)=>this.setState({username:text})}
                        >
                    </TextInput>
                    <TextInput
                        style={style.textInput}
                        placeholder='Jelszó!'
                        value={this.state.no_hash}
                        onChangeText={(text)=>this.setState({no_hash:text})}
                    >
                    </TextInput>
                    <Button title="Adatok hozzáadás"
                    onPress={()=>this.pressButton()}>
    
                    </Button>
                </View>
            </View>
        );
    }
    }

export default Front;