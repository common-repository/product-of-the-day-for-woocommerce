// External Dependencies
import React, { Component } from 'react';

class BAPOFproductOfDay extends Component {

  static slug = 'et_pb_br_product_of_day';
  static parameters = ['widget_position',
            'products_count',
            'random',
            'type',
            'count_line',
            'thumbnails',
            'add_to_cart',
            'hide_outofstock'];
  constructor(props) {
    super(props);
    this.htmlstate = <div></div>;
    this.state = {
      error: null,
      isLoaded: false
    };
  }
  render() {
    const { error, isLoaded } = this.state;

    if (error) {
      return (<div>{error.message}</div>);
    } else if (!isLoaded) {
      return (<div style={{height:"100px"}}><div class="et-fb-loader-wrapper"><div class="et-fb-loader"></div></div></div>);
    } else {
      return this.htmlstate;
    }
  }

  componentDidUpdate(oldProps) {
      var update = false;
      BAPOFproductOfDay.parameters.forEach(key => {
          if( oldProps[key] != this.props[key] ) {
              update = true;
          }
      });
      if( update ) {
        this.setState({
          error: null,
          isLoaded: false
        });
        this.componentDidMount();
      }
  }
  componentDidMount() {
    var body = new FormData();
    body.append('action', 'brpof_product_of_day');
    var newProps = this.props;
    Object.keys(newProps).forEach(key => {
      body.append(key, newProps[key]);
    });
    
    fetch(
      window.et_fb_options.ajaxurl, 
      {
        body: body,
        method: 'POST',        
      }
    )
      .then(res => res.text())
      .then(
        (result) => {
          if( typeof(result) === 'undefined' || ! result ) {
              this.htmlstate = (<div style={{padding:"2em 0", background: "#6c2eb9", color: "#fff", fontSize: "12px", fontWeight: "600", verticalAlign: "middle", textAlign: "center", borderRadius: "1em"}}><h3 style={{color: "#000", textShadow: "1px 0px white, -1px 0px white, 0px 1px white, 0px -1px white", fontWeight: "900"}}>BeRocket Products of Day</h3>Products of Day not displayed in Builder</div>);
              this.setState({
                isLoaded: true
              });
          } else {
              this.htmlstate = (<div dangerouslySetInnerHTML={{__html: result}} />);
              this.setState({
                isLoaded: true
              });
              document.dispatchEvent(new CustomEvent('bapf_update_et_pb_br_filter_single', { 'bubbles': true }));
              const brevent = new Event('br_update_et_product_of_day');
              window.dispatchEvent(brevent);
          }
        },
        (error) => {
          this.htmlstate = (<div style={{padding:"2em 0", background: "#6c2eb9", color: "#fff", fontSize: "12px", fontWeight: "600", verticalAlign: "middle", textAlign: "center", borderRadius: "1em"}}><h3 style={{color: "#000", textShadow: "1px 0px white, -1px 0px white, 0px 1px white, 0px -1px white", fontWeight: "900"}}>BeRocket Products of Day</h3>Products of Day not displayed in Builder</div>);
          this.setState({
            isLoaded: true
          });
        }
      )
  }
}

export default BAPOFproductOfDay;
